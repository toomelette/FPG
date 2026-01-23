<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MergeCosPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $folder;
    /**
     * Create a new job instance.
     */
    public function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdfFiles = [];
        $filesInsideFolder = Storage::disk('contracts_temp')->files($this->folder);
        $pdfPaths = array_map(fn($file) => Storage::disk('contracts_temp')->path($file), $filesInsideFolder);

        $pdf = new \setasign\Fpdi\Fpdi();


        foreach ($pdfPaths as $file) {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }
        }
//        $outputPath = Storage::disk('contracts_temp')->path('/'.$folder.'.pdf');
        $pdfContent = $pdf->Output('S');
        $path = $this->folder.'/AAA.pdf';
        Storage::disk('contracts_temp')->put($path,$pdfContent);
        //Storage::disk('contracts_temp')->deleteDirectory($folder);
    }
}
