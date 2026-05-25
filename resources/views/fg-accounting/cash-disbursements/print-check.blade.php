@extends('printables.print_layouts.print_layout_main')

@section('wrapper')

    <div style="font-family: Cambria">
        <div class="no-print">
            <div class="row" style="padding: 15px 15px 0px 15px">
                <x-forms.input label="Name on Check" name="name" class="editable" cols="4" :value="$journal->counterparty"/>
                <x-forms.input label="Date" name="date" cols="2" class="editable" type="date" :value="$journal->date"/>
            </div>
            <div class="row" style="padding: 0px 15px 20px 15px">
                <div class="col-md-1">
                    <button class="btn btn-primary" onclick="print()">Print</button>
                </div>
            </div>
        </div>
        <div class="printable">
            <span id="name">{{$journal->counterparty}}</span>
            <span id="date">{{$journal->date}}</span>
        </div>
    </div>

    <x-adminkit.html.modal-template id="edit-modal" size="sm" form-id="edit-form">
        <x-slot:title></x-slot:title>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("body").on('change keyup','.editable',function (){
            let currentVal = $(this).val();
            let targetId = $(this).attr('name');
            if($(this).attr('type') === 'date'){
                currentVal = moment(currentVal).format('YY-MM-DD')
            }
            $(".printable").find('span#'+targetId).html(currentVal)

        });
    </script>
@endsection