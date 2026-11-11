@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title></x-slot:title>
        <x-slot:subtitle></x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>


    <h3>{{ $document->original_filename ?? 'Excel Viewer' }}</h3>

    <div id="status">Loading Excel...</div>

    <div id="spreadsheet"></div>

    <button type="button" onclick="saveExcel()">
        Save Changes
    </button>
@endsection


@section('modals')

@endsection

@section('scripts')
    <!-- Jspreadsheet CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/jspreadsheet-ce@5/dist/jspreadsheet.min.css">

    <!-- JSuites CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/jsuites@5/dist/jsuites.min.css">

    <!-- JSuites -->
    <script src="https://cdn.jsdelivr.net/npm/jsuites@5/dist/jsuites.min.js"></script>

    <!-- Jspreadsheet CE -->
    <script src="https://cdn.jsdelivr.net/npm/jspreadsheet-ce@5/dist/index.min.js"></script>

    <!-- ExcelJS -->
    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>

    <script>
        let workbook;
        let worksheet;
        let spreadsheet;

        async function loadExcel() {

            try {

                document.getElementById('status').innerText = 'Loading Excel...';

                // 1. Fetch Excel file from Laravel
                const response = await fetch(
                        @json('/excel-read')
                );

                if (!response.ok) {
                    throw new Error('Unable to retrieve Excel file.');
                }

                // 2. Read file as ArrayBuffer
                const buffer = await response.arrayBuffer();

                // 3. Load workbook using ExcelJS
                workbook = new ExcelJS.Workbook();

                await workbook.xlsx.load(buffer);

                // 4. Get first worksheet
                worksheet = workbook.worksheets[0];

                if (!worksheet) {
                    throw new Error('No worksheet found.');
                }

                // 5. Convert worksheet data
                const data = [];

                for (let rowNumber = 1; rowNumber <= worksheet.rowCount; rowNumber++) {

                    const row = [];

                    for (let colNumber = 1; colNumber <= worksheet.columnCount; colNumber++) {

                        const cell = worksheet.getRow(rowNumber).getCell(colNumber);

                        let value = cell.value;

                        // Handle different Excel cell value types
                        if (value && typeof value === 'object') {

                            if (value.formula) {
                                value = '=' + value.formula;
                            } else if (value.richText) {
                                value = value.richText.map(item => item.text).join('');
                            } else if (value.text !== undefined) {
                                value = value.text;
                            } else {
                                value = cell.text;
                            }

                        } else if (value instanceof Date) {

                            value = value.toISOString();

                        }

                        row.push(value ?? '');

                    }

                    data.push(row);

                }

                // 6. Initialize Jspreadsheet
                const sheets = jspreadsheet(
                    document.getElementById('spreadsheet'),
                    {
                        worksheets: [{
                            data: data,
                            minDimensions: [
                                Math.max(worksheet.columnCount, 10),
                                Math.max(worksheet.rowCount, 20)
                            ],
                            tableOverflow: true,
                            tableHeight: '70vh',
                            columnSorting: false
                        }]
                    }
                );

                spreadsheet = sheets[0];

                document.getElementById('status').innerText =
                    'Excel loaded successfully.';

            } catch (error) {

                console.error(error);

                document.getElementById('status').innerText =
                    error.message;

            }

        }

        loadExcel();

        async function saveExcel() {

            try {

                // Get edited spreadsheet data
                const data = spreadsheet.getData();

                // Update existing ExcelJS worksheet
                data.forEach((row, rowIndex) => {

                    row.forEach((value, colIndex) => {

                        const cell = worksheet
                            .getRow(rowIndex + 1)
                            .getCell(colIndex + 1);

                        cell.value = value === '' ? null : value;

                    });

                });

                // Export workbook
                const buffer = await workbook.xlsx.writeBuffer();

                // Prepare upload
                const formData = new FormData();

                formData.append(
                    'workbook',
                    new Blob([buffer], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    }),
                    'updated.xlsx'
                );

                // Send to Laravel
                const response = await fetch(
                        @json('/excel-save'),
                    {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': @json(csrf_token()),
                            'Accept': 'application/json'
                        },
                        body: formData
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Save failed.');
                }

                alert(result.message);

            } catch (error) {

                console.error(error);
                alert(error.message);

            }

        }
    </script>

    <script type="text/javascript">


    </script>
@endsection