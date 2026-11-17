@extends('adminkit.master')

@section('content2')

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <div class="row">
                <div class="col-md-6">
                    <x-forms.input label="" name="description" id="description" cols="12" :input-only="true" :value="$costing->description"/>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end">
                        <a  type="button" href="{{route('costing.edit',$costing->uuid)}}?download"
                            class="btn btn-outline-secondary btn-sm edit-costing-btn">
                            <i class="fa fa-download"></i>
                        </a>
                        <button type="button" id="saveExcel" class="btn btn-primary btn-sm">
                            <i class="fa fa-check"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </x-slot:title>


        <div id="status">Preparing Excel editor...</div>

        <div id="luckysheet"
             style="position:relative;width:100%;height:70vh;">
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')


    <!-- LuckyExcel -->
    <script src="https://cdn.jsdelivr.net/npm/luckyexcel/dist/luckyexcel.umd.js"></script>

    <!-- Preserve AdminKit jQuery -->
    <script>
        window.adminJQuery = window.jQuery;
        window.adminDollar = window.$;
    </script>

    <!-- Luckysheet bundles its own jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/luckysheet@2.1.12/dist/plugins/js/plugin.js"></script>

    <!-- Luckysheet -->
    <script src="https://cdn.jsdelivr.net/npm/luckysheet@2.1.12/dist/luckysheet.umd.js"></script>

    <!-- DO NOT restore AdminKit jQuery globally -->



    <script type="text/javascript">

        async function loadExcel() {
            const status = document.getElementById('status');

            try {
                status.innerText = 'Loading Excel...';

                const response = await fetch(
                        @json(route('costing.edit', ['read-excel' => true, 'costing' => $costing->uuid])),
                    { cache: 'no-store' }
                );

                if (!response.ok) {
                    throw new Error('Unable to load Excel file.');
                }

                const blob = await response.blob();

                LuckyExcel.transformExcelToLucky(
                    blob,
                    function (exportJson, luckysheetfile) {
                        try {
                            console.log('LuckyExcel export:', exportJson);

                            if (!exportJson || !exportJson.sheets) {
                                throw new Error('Invalid Excel workbook.');
                            }

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

                            status.style.display = 'none';

                        } catch (error) {
                            console.error('Luckysheet initialization error:', error);
                            status.innerText = error.message;
                        }
                    }
                );

            } catch (error) {
                console.error('Excel loading error:', error);
                status.innerText = error.message;
            }
        }

        loadExcel();

        async function saveExcel() {
            const button = document.getElementById('saveExcel');
            let btn = $('#saveExcel');
            wait_this_button(btn,'Save Changes');
            try {
                button.disabled = true;
                const sheets = luckysheet.getAllSheets();
                const response = await fetch(
                        @json(route('costing.update',['costing' => $costing->uuid,'update-excel' => true])),
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content
                        },
                        body: JSON.stringify({
                            sheets : sheets,
                            description : $("#description").val(),
                        })
                    }
                );

                console.log('Complete sheet:', sheets[0]);
                console.log('Border info:', sheets[0].config?.borderInfo);

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Unable to save workbook.');
                }


                window.adminJQuery.toast({
                    text: 'Workbook successfully saved.', // Text that is to be shown in the toast
                    heading: 'Success', // Optional heading to be shown on the toast
                    icon: 'success', // Type of toast icon
                    showHideTransition: 'slide', // fade, slide or plain
                    allowToastClose: true, // Boolean value true or false
                    hideAfter: 5000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                    stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                    position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                    textAlign: 'left',  // Text alignment i.e. left, right or center
                    loader: false,  // Whether to show loader or not. True by default
                    loaderBg: '#9EC600',  // Background color of the toast loader
                });

                unwait_this_button(btn);
            } catch (error) {
                console.error(error);
                alert(error.message);
                unwait_this_button(btn);
            } finally {
                button.disabled = false;
                unwait_this_button(btn);
            }
        }

        document.getElementById('saveExcel')
            .addEventListener('click', saveExcel);
    </script>

@endsection