@extends('adminkit.master')

@section('content2')

    <x-adminkit.html.page-title>
        <x-slot:title></x-slot:title>
        <x-slot:subtitle></x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <button type="button" id="saveExcel" class="btn btn-primary">
        Save Changes
    </button>

    <div id="status">Preparing Excel editor...</div>

    <div id="luckysheet"
         style="position:relative;width:100%;height:80vh;">
    </div>

@endsection


@section('modals')

@endsection

@section('scripts')

    <!-- LuckyExcel -->
    <script src="https://cdn.jsdelivr.net/npm/luckyexcel/dist/luckyexcel.umd.js"></script>

    <!-- Luckysheet dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/luckysheet@2.1.12/dist/plugins/js/plugin.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/luckysheet@2.1.12/dist/luckysheet.umd.js"></script>

    <script type="text/javascript">
        async function loadExcel() {

            try {

                document.getElementById('status').innerText =
                    'Loading Excel...';

                // Fetch Excel from Laravel
                const response = await fetch(
                        @json('/excel-read')
                );

                if (!response.ok) {
                    throw new Error('Unable to load Excel file.');
                }

                const blob = await response.blob();

                // Import Excel using LuckyExcel
                LuckyExcel.transformExcelToLucky(
                    blob,
                    function (exportJson, luckysheetfile) {

                        if (!exportJson || !exportJson.sheets) {
                            throw new Error('Invalid Excel workbook.');
                        }

                        // Initialize Luckysheet
                        luckysheet.create({
                            container: 'luckysheet',
                            lang: 'en',
                            data: exportJson.sheets,
                            title: @json($document->original_filename ?? 'Excel Editor'),
                            showinfobar: false,
                            showsheetbar: true,
                            showtoolbar: true,
                            showformulaBar: true,
                            enableAddRow: true,
                            enableAddCol: true
                        });

                        document.getElementById('status').innerText =
                            'Excel loaded successfully.';

                    }
                );

            } catch (error) {

                console.error(error);

                document.getElementById('status').innerText =
                    error.message;

            }

        }

        loadExcel();
        async function saveExcel() {
            const button = document.getElementById('saveExcel');

            try {
                button.disabled = true;


                const sheets = luckysheet.getAllSheets();

                const response = await fetch(
                        @json('/excel-save'),
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },
                        body: JSON.stringify({ sheets })
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Unable to save workbook.');
                }

                setStatus('Excel workbook saved successfully.');

            } catch (error) {
                console.error(error);
                setStatus(error.message);

            } finally {
                button.disabled = false;
            }
        }

        document.getElementById('saveExcel')
            .addEventListener('click', saveExcel);
    </script>
@endsection