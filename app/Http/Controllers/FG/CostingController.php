<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CostingFormRequest;
use App\Models\FG\CostingLogs;
use App\Models\FG\Costings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CostingController extends Controller
{
    public function store(CostingFormRequest $request)
    {
        $validated = $request->validate([
            'excel' => ['required', 'file', 'mimes:xls,xlsx'],
            'folder_uuid' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);


        $file = $request->file('excel');
        $uuid = Str::uuid();
        $filename = $uuid . '.xlsx';
        $directory = $validated['folder_uuid'];

        $disk = Storage::disk('costing-excels');

        $disk->makeDirectory($directory);

        $path = $directory . '/' . $filename;

        try {

            // Convert XLS to XLSX or store existing XLSX
            if (strtolower($file->getClientOriginalExtension()) === 'xls') {

                $reader = IOFactory::createReader('Xls');
                $reader->setReadDataOnly(false);

                $spreadsheet = $reader->load($file->getRealPath());

                try {
                    $writer = new Xlsx($spreadsheet);

                    $writer->setPreCalculateFormulas(false);

                    $writer->save($disk->path($path));

                } finally {
                    $spreadsheet->disconnectWorksheets();
                    unset($spreadsheet);
                }

                // Verify converted file
                if (!$disk->exists($path) || $disk->size($path) === 0) {
                    throw new \RuntimeException(
                        'XLS to XLSX conversion failed.'
                    );
                }

            } else {

                // Store original XLSX
                $storedPath = $file->storeAs(
                    $directory,
                    $filename,
                    'costing-excels'
                );

                if (!$storedPath) {
                    throw new \RuntimeException(
                        'Unable to store Excel file.'
                    );
                }
            }

            // Create costing record
            $costing = new Costings();

            $costing->uuid = $uuid;
            $costing->folder_uuid = $directory;
            $costing->description = $validated['description'] ?? null;
            $costing->excel_path = $filename;
            $costing->original_filename = $file->getClientOriginalName();

            DB::transaction(function () use ($costing) {
                $costing->save();
            });

            return response()->json([
                'success' => true,
                'uuid' => $costing->uuid,
                'message' => 'Costing uploaded successfully.',
            ]);

        } catch (\Throwable $exception) {

            // Remove uploaded or converted file if something fails
            if ($disk->exists($path)) {
                $disk->delete($path);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to upload or convert Excel file.',
            ], 500);
        }
    }

    public function edit($uuid,Request $request)
    {
        $costing = Costings::query()->findOrFail($uuid);
        if($request->has('read-excel')){
            return  $this->readExcel($costing);
        }

        return view('fg.costing.edit')->with([
            'costing' => $costing,
        ]);
    }

    public function update($uuid,Request $request)
    {
        $costing = Costings::query()->findOrFail($uuid);
        if($request->has('update-excel')){
            return $this->updateExcel($costing,$request);
        }
        dd($request->all());
    }

    /*
    public function updateExcel(Costings $costing, Request $request)
    {
        $validated = $request->validate([
            'sheets' => ['required', 'array'],
            'sheets.*.name' => ['required', 'string'],
            'sheets.*.celldata' => ['nullable', 'array'],
            'description' => ['required'],
        ]);
        $costing->description = $request->description;
        $costing->save();
        $disk = Storage::disk('costing-excels');
        $changes = [];
        $filePath = $costing->folder_uuid . '/' . $costing->excel_path;

        if (!$disk->exists($filePath)) {
            return response()->json([
                'message' => 'Excel file not found.',
            ], 404);
        }

        $tempPath = null;

        try {
            $path = $disk->path($filePath);

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

            foreach ($validated['sheets'] as $sheetData) {

                $worksheet = $spreadsheet->getSheetByName($sheetData['name']);

                if (!$worksheet) {
                    continue;
                }

                foreach ($sheetData['celldata'] ?? [] as $cell) {

                    if (!isset($cell['r'], $cell['c'])) {
                        continue;
                    }

                    $coordinate =
                        \PhpOffice\PhpSpreadsheet\Cell\Coordinate::
                        stringFromColumnIndex($cell['c'] + 1)
                        . ($cell['r'] + 1);

                    $value = $cell['v'] ?? null;

                    // Get old value and formula
                    $oldCell = $worksheet->getCell($coordinate);
                    $oldValue = $oldCell->getValue();

                    // Determine new value or formula
                    if (is_array($value) && !empty($value['f'])) {

                        $formula = $value['f'];

                        $newValue = str_starts_with($formula, '=')
                            ? $formula
                            : '=' . $formula;

                    } else {

                        $newValue = is_array($value)
                            ? ($value['v'] ?? null)
                            : $value;
                    }

                    // Record value changes
                    if ($oldValue !== $newValue) {

                        $changes[] = [
                            'sheet' => $sheetData['name'],
                            'cell' => $coordinate,
                            'type' => 'value',
                            'old_value' => $oldValue,
                            'new_value' => $newValue,
                        ];
                    }

                    // Set cell value
                    $worksheet->setCellValue($coordinate, $newValue);

                    // Apply formatting
                    if (!is_array($value)) {
                        continue;
                    }

                    $font = [];

                    if (isset($value['ff'])) {
                        $font['name'] = $value['ff'];
                    }

                    if (isset($value['fs'])) {
                        $font['size'] = $value['fs'];
                    }

                    if (isset($value['bl'])) {
                        $font['bold'] = (bool) $value['bl'];
                    }

                    if (isset($value['it'])) {
                        $font['italic'] = (bool) $value['it'];
                    }

                    if (isset($value['un'])) {
                        $font['underline'] = $value['un']
                            ? \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE
                            : \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE;
                    }

                    if (isset($value['cl'])) {
                        $font['strikethrough'] = (bool) $value['cl'];
                    }

                    if (isset($value['fc'])) {
                        $font['color'] = [
                            'rgb' => strtoupper(ltrim($value['fc'], '#')),
                        ];
                    }

                    if (!empty($font)) {
                        $worksheet->getStyle($coordinate)->applyFromArray([
                            'font' => $font,
                        ]);
                    }
                }
            }



            $tempPath = tempnam(sys_get_temp_dir(), 'excel_');

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            $writer->save($tempPath);

            $stream = fopen($tempPath, 'rb');

            if (!$stream) {
                throw new \RuntimeException('Unable to read temporary Excel file.');
            }

            try {
                if (!$disk->put($filePath, $stream)) {
                    throw new \RuntimeException('Unable to save Excel file.');
                }
            } finally {
                fclose($stream);
            }

            $spreadsheet->disconnectWorksheets();

            DB::transaction(function () use ($changes,$costing){
                $logs = new CostingLogs();
                $logs->costing_uuid = $costing->uuid;
                $logs->changes = $changes;
                $logs->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Excel saved successfully.',
            ]);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to save Excel workbook.',
            ], 500);

        } finally {
            if ($tempPath && file_exists($tempPath)) {
                unlink($tempPath);
            }
        }




    }
*/



    public function updateExcel(Costings $costing, Request $request)
    {
        $validated = $request->validate([
            'sheets' => ['required', 'array'],
            'sheets.*.name' => ['required', 'string'],
            'sheets.*.celldata' => ['nullable', 'array'],
            'sheets.*.config' => ['nullable', 'array'],
            'sheets.*.config.borderInfo' => ['nullable', 'array'],
            'description' => ['required'],
        ]);
//        return $validated['sheets'];
//        dd($validated['sheets'][0]['celldata']);
        $disk = Storage::disk('costing-excels');
        $changes = [];

        $filePath = $costing->folder_uuid . '/' . $costing->excel_path;

        if (!$disk->exists($filePath)) {
            return response()->json([
                'message' => 'Excel file not found.',
            ], 404);
        }

        $tempPath = null;
        $spreadsheet = null;

        try {
            $path = $disk->path($filePath);

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

            foreach ($validated['sheets'] as $sheetData) {

                $worksheet = $spreadsheet->getSheetByName($sheetData['name']);

                if (!$worksheet) {
                    continue;
                }

                /*
                 * STEP 1:
                 * Store original cell values before clearing them.
                 */
                $originalValues = [];

                foreach ($worksheet->getCellCollection()->getCoordinates() as $coordinate) {

                    $oldValue = $worksheet->getCell($coordinate)->getValue();

                    if ($oldValue !== null) {
                        $originalValues[$coordinate] = $oldValue;

                        // Clear old value but retain existing formatting.
                        $worksheet->getCell($coordinate)->setValue(null);
                    }
                }

                /*
                 * STEP 2:
                 * Write current Luckysheet cells.
                 */
                $newCoordinates = [];

                foreach ($sheetData['celldata'] ?? [] as $cell) {

                    if (!isset($cell['r'], $cell['c'])) {
                        continue;
                    }

                    $coordinate =
                        \PhpOffice\PhpSpreadsheet\Cell\Coordinate::
                        stringFromColumnIndex($cell['c'] + 1)
                        . ($cell['r'] + 1);

                    $newCoordinates[$coordinate] = true;

                    $value = $cell['v'] ?? null;

                    // Get original value for audit logging.
                    $oldValue = $originalValues[$coordinate] ?? null;

                    // Determine new value or formula.
                    if (is_array($value) && !empty($value['f'])) {

                        $formula = $value['f'];

                        $newValue = str_starts_with($formula, '=')
                            ? $formula
                            : '=' . $formula;

                    } else {

                        $newValue = is_array($value)
                            ? ($value['v'] ?? null)
                            : $value;
                    }

                    // Record value changes.
                    if ($oldValue !== $newValue) {

                        $changes[] = [
                            'sheet' => $sheetData['name'],
                            'cell' => $coordinate,
                            'type' => 'value',
                            'old_value' => $oldValue,
                            'new_value' => $newValue,
                        ];
                    }

                    // Set cell value.
                    $worksheet->setCellValue($coordinate, $newValue);

                    // Apply formatting.
                    if (!is_array($value)) {
                        continue;
                    }

                    $font = [];

                    if (isset($value['ff'])) {
                        $font['name'] = $value['ff'];
                    }

                    if (isset($value['fs'])) {
                        $font['size'] = $value['fs'];
                    }

                    if (isset($value['bl'])) {
                        $font['bold'] = (bool) $value['bl'];
                    }

                    if (isset($value['it'])) {
                        $font['italic'] = (bool) $value['it'];
                    }

                    if (isset($value['un'])) {
                        $font['underline'] = $value['un']
                            ? \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE
                            : \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_NONE;
                    }

                    if (isset($value['cl'])) {
                        $font['strikethrough'] = (bool) $value['cl'];
                    }

                    if (isset($value['fc'])) {
                        $font['color'] = [
                            'rgb' => strtoupper(ltrim($value['fc'], '#')),
                        ];
                    }

                    if (!empty($font)) {
                        $worksheet->getStyle($coordinate)->applyFromArray([
                            'font' => $font,
                        ]);
                    }

                    // Apply horizontal and vertical alignment
                    $alignment = [];

                    if (isset($value['ht'])) {
                        $alignment['horizontal'] = match ((int) $value['ht']) {
                            0 => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            1 => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                            2 => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                            default => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_GENERAL,
                        };
                    }

                    if (isset($value['vt'])) {
                        $alignment['vertical'] = match ((int) $value['vt']) {
                            1 => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                            2 => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_BOTTOM,
                            default => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        };
                    }

                    if (!empty($alignment)) {
                        $worksheet->getStyle($coordinate)->applyFromArray([
                            'alignment' => $alignment,
                        ]);
                    }


                    // Apply borders
                    if (isset($value['bd']) && is_array($value['bd'])) {

                        $borders = [];

                        $borderMap = [
                            '1' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            '2' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                            '3' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
                            '4' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED,
                            '5' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOT,
                            '6' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOTDOT,
                            '7' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            '8' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            '9' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHED,
                            '10' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHDOT,
                            '11' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHDOTDOT,
                            '12' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_SLANTDASHDOT,
                            '13' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        ];

                        $sides = [
                            'l' => 'left',
                            'r' => 'right',
                            't' => 'top',
                            'b' => 'bottom',
                        ];

                        foreach ($sides as $luckysheetSide => $excelSide) {

                            $border = $value['bd'][$luckysheetSide] ?? null;

                            if (!$border || empty($border['style'])) {
                                continue;
                            }

                            $style = $borderMap[(string) $border['style']] ?? null;

                            if (!$style) {
                                continue;
                            }

                            $borders[$excelSide] = [
                                'borderStyle' => $style,
                            ];

                            if (!empty($border['color'])) {
                                $borders[$excelSide]['color'] = [
                                    'rgb' => strtoupper(ltrim($border['color'], '#')),
                                ];
                            }
                        }

                        if (!empty($borders)) {
                            $worksheet->getStyle($coordinate)->applyFromArray([
                                'borders' => $borders,
                            ]);
                        }
                    }

                    /*
                     * Background / Fill Color
                     */
                    if (isset($value['bg'])) {

                        $backgroundColor = $value['bg'];

                        if (
                            is_string($backgroundColor) &&
                            $backgroundColor !== '' &&
                            strtolower($backgroundColor) !== 'transparent'
                        ) {
                            $worksheet->getStyle($coordinate)->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'startColor' => [
                                        'rgb' => strtoupper(ltrim($backgroundColor, '#')),
                                    ],
                                ],
                            ]);
                        } else {
                            // Remove existing background color if cleared in Luckysheet
                            $worksheet->getStyle($coordinate)->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE,
                                ],
                            ]);
                        }
                    }
                }



                /*
                 * STEP 2.5:
                 * Synchronize Luckysheet borders.
                 */

                $borderInfo = $sheetData['config']['borderInfo'] ?? [];

                /*
                 * 1. Clear existing borders first.
                 * This also handles borders removed in Luckysheet.
                 */
                if (isset($sheetData['config']['borderInfo'])) {

                    $coordinates = $worksheet->getCellCollection()->getCoordinates();

                    foreach ($coordinates as $coordinate) {
                        $worksheet->getStyle($coordinate)->applyFromArray([
                            'borders' => [
                                'left' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                                ],
                                'right' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                                ],
                                'top' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                                ],
                                'bottom' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                                ],
                            ],
                        ]);
                    }
                }

                /*
                 * 2. Luckysheet border style to PhpSpreadsheet border style.
                 */
                $borderMap = [
                    1  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    2  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
                    3  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
                    4  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED,
                    5  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOT,
                    6  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOTDOT,
                    7  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                    8  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    9  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHED,
                    10 => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHDOT,
                    11 => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUMDASHDOTDOT,
                    12 => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_SLANTDASHDOT,
                    13 => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ];

                $sides = [
                    'l' => 'left',
                    'r' => 'right',
                    't' => 'top',
                    'b' => 'bottom',
                ];

                /*
                 * 3. Reapply Luckysheet borders.
                 */
                foreach ($borderInfo as $borderData) {

                    /*
                     * CASE 1: Individual cell borders.
                     */
                    if (($borderData['rangeType'] ?? null) === 'cell') {

                        $border = $borderData['value'] ?? [];

                        if (!isset($border['row_index'], $border['col_index'])) {
                            continue;
                        }

                        $coordinate =
                            \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                                $border['col_index'] + 1
                            ) . ($border['row_index'] + 1);

                        $borders = [];

                        foreach ($sides as $luckysheetSide => $excelSide) {

                            $side = $border[$luckysheetSide] ?? null;

                            if (!$side || empty($side['style'])) {
                                continue;
                            }

                            $style = $borderMap[(int) $side['style']] ?? null;

                            if (!$style) {
                                continue;
                            }

                            $borders[$excelSide] = [
                                'borderStyle' => $style,
                            ];

                            if (!empty($side['color'])) {
                                $borders[$excelSide]['color'] = [
                                    'rgb' => strtoupper(ltrim($side['color'], '#')),
                                ];
                            }
                        }

                        if (!empty($borders)) {
                            $worksheet->getStyle($coordinate)->applyFromArray([
                                'borders' => $borders,
                            ]);
                        }

                        continue;
                    }

                    /*
                     * CASE 2: Borders applied to a selected range.
                     */
                    if (($borderData['rangeType'] ?? null) === 'range') {

                        $style = $borderMap[(int) ($borderData['style'] ?? 0)] ?? null;

                        if (!$style) {
                            continue;
                        }

                        $color = strtoupper(ltrim($borderData['color'] ?? '#000000', '#'));

                        $borderStyle = [
                            'borderStyle' => $style,
                            'color' => [
                                'rgb' => $color,
                            ],
                        ];

                        $borderType = $borderData['borderType'] ?? '';

                        $borders = match ($borderType) {
                            'border-all' => [
                                'allBorders' => $borderStyle,
                            ],
                            'border-outside' => [
                                'outline' => $borderStyle,
                            ],
                            'border-inside' => [
                                'inside' => $borderStyle,
                            ],
                            'border-horizontal' => [
                                'horizontal' => $borderStyle,
                            ],
                            'border-vertical' => [
                                'vertical' => $borderStyle,
                            ],
                            'border-left' => [
                                'left' => $borderStyle,
                            ],
                            'border-right' => [
                                'right' => $borderStyle,
                            ],
                            'border-top' => [
                                'top' => $borderStyle,
                            ],
                            'border-bottom' => [
                                'bottom' => $borderStyle,
                            ],
                            default => [],
                        };

                        if (empty($borders)) {
                            continue;
                        }

                        foreach ($borderData['range'] ?? [] as $range) {

                            $rows = $range['row'] ?? null;
                            $columns = $range['column'] ?? null;

                            if (
                                !is_array($rows) ||
                                !is_array($columns) ||
                                count($rows) < 2 ||
                                count($columns) < 2
                            ) {
                                continue;
                            }

                            $startCell =
                                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                                    $columns[0] + 1
                                ) . ($rows[0] + 1);

                            $endCell =
                                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                                    $columns[1] + 1
                                ) . ($rows[1] + 1);

                            $worksheet->getStyle($startCell . ':' . $endCell)
                                ->applyFromArray([
                                    'borders' => $borders,
                                ]);
                        }
                    }
                }


                /*
                 * STEP 3:
                 * Record original cells that no longer exist
                 * in the current Luckysheet data.
                 */
                foreach ($originalValues as $coordinate => $oldValue) {

                    if (!isset($newCoordinates[$coordinate])) {

                        $changes[] = [
                            'sheet' => $sheetData['name'],
                            'cell' => $coordinate,
                            'type' => 'value',
                            'old_value' => $oldValue,
                            'new_value' => null,
                        ];
                    }
                }
            }

            /*
             * STEP 4:
             * Save the updated workbook.
             */
            $tempPath = tempnam(sys_get_temp_dir(), 'excel_');

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            $writer->save($tempPath);

            $stream = fopen($tempPath, 'rb');

            if (!$stream) {
                throw new \RuntimeException('Unable to read temporary Excel file.');
            }

            try {
                if (!$disk->put($filePath, $stream)) {
                    throw new \RuntimeException('Unable to save Excel file.');
                }
            } finally {
                fclose($stream);
            }

            $spreadsheet->disconnectWorksheets();
            $spreadsheet = null;

            /*
             * STEP 5:
             * Save description and audit logs.
             */
            DB::transaction(function () use ($changes, $costing, $validated) {

                $costing->description = $validated['description'];
                $costing->save();

                if (!empty($changes)) {

                    $logs = new CostingLogs();

                    $logs->costing_uuid = $costing->uuid;
                    $logs->changes = $changes;

                    $logs->save();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Excel saved successfully.',
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to save Excel workbook.',
            ], 500);

        } finally {

            if ($spreadsheet) {
                $spreadsheet->disconnectWorksheets();
            }

            if ($tempPath && file_exists($tempPath)) {
                unlink($tempPath);
            }
        }
    }


    private function readExcel(Costings $costing)
    {

        $disk = Storage::disk('costing-excels');

        $xlsPath = $costing->folder_uuid.'/'.$costing->excel_path;
        $xlsxPath = $costing->folder_uuid.'/'.$costing->excel_path;

        $originalPath = $disk->path($xlsPath);


        if (!file_exists($originalPath)) {
            abort(404, 'Excel file not found.');
        }

        // Serve the converted XLSX.
        return response()->file(
            $disk->path($xlsxPath),
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        );
    }

    public function destroy($uuid)
    {
        $costing = Costings::query()->findOrFail($uuid);
        $disk = Storage::disk('costing-excels');
        $xlsPath = $costing->folder_uuid . '/' . $costing->excel_path;
        DB::transaction(function () use ($costing) {
            $costing->logs()->delete();
            $costing->delete();
        });
        // Delete physical Excel file after successful database deletion
        $disk->delete($xlsPath);
        return 1;
    }
}
