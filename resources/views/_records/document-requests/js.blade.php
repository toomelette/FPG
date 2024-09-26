<script type="text/javascript">
    $("#add-request-form").submit(function (e) {
        e.preventDefault()
        let form = $(this);
        loading_btn(form);
        $.ajax({
            url : '{{route("dashboard.document_request.store")}}',
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                active = res.slug;
                requestsTbl.draw(false);
                succeed(form,true,true);
            },
            error: function (res) {
                errored(form,res);
            }
        })
    })

    $("body").on('change',"input[name='requesting_party']", function (){
        let parentForm = $(this).parents('form');
        let selected = $(this).val();
        let specify = parentForm.find("input[name='requesting_party_specify']").parent('.form-group');
        if(selected === 'Other Government Agencies'){
            specify.removeClass('visually-hidden');
        }else{
            specify.addClass('visually-hidden');
        }
    });

    $("body").on('change',"input[name='purpose']", function (){
        let parentForm = $(this).parents('form');
        let selected = $(this).val();
        let specify = parentForm.find("input[name='purpose_specify']").parent('.form-group');
        if(selected === 'Others'){
            specify.removeClass('visually-hidden');
        }else{
            specify.addClass('visually-hidden');
        }
    });

    $("body").on("click",".edit-document-request-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.document_request.edit","slug")}}';
        uri = uri.replace('slug',btn.attr('data'));
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })
</script>