/* jshint esversion: 6 */
$("#details-table").on("keyup change",'[class*="autonum-"]',function (){
    let table = $(this).closest('table');
    let totalDebit = 0;
    let totalCredit = 0;
    $(table).find("input[class*='autonum-']").each(function (){
        let $element = $(this);
        let name = $element.attr('name');
        if(name.includes(['debit'])){
            totalDebit = totalDebit + sanitizeAutonum($element.val());
        }
        if(name.includes('credit')){
            totalCredit = totalCredit + sanitizeAutonum($element.val());
        }
    })
    $("#total-debit").html($.number(totalDebit,2));
    $("#total-credit").html($.number(totalCredit,2));
})

$("#projects-table").on("keyup change",'[class*="autonum-"]',function (){
    let table = $(this).closest('table');
    let totalAmount = 0;
    $(table).find("input[class*='autonum-']").each(function (){
        let $element = $(this);
        totalAmount = totalAmount + sanitizeAutonum($element.val());
    })
    $("#total-amount").html($.number(totalAmount,2));
})


$("body").on('change','.select2-client-by-class', function () {
    let tr = $(this).closest('tr');
    tr.find('[id*="select2-sales-invoice"]').val(null).trigger('change');
});

$("body").on("click",".add-btn",function (){
    let btn = $(this);
    let table = btn.parents('table');
    let templateId = btn.attr('template');
    let rand = makeId(5);
    let template = $(templateId).html().replaceAll('rand',rand);
    table.find('tbody')
        .append(template)
        .ready(function (){
            initializeAutonumByClass('.autonum-'+rand);
            $("#select2-details-"+rand).select2({
                    ajax: {
                    url: '/dashboard/ajax/project-expense-liquidation-description',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                },
                tags: true,
                placeholder: "Select",
                allowClear: true,
                createTag: function (params) {
                    let term = $.trim(params.term);
                    if (term === '') return null;

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                },
                templateResult: function (data) {
                    if (data.loading) return data.text;

                    if (data.newTag) {
                        return $('<span>Add "<b>' + data.text + '</b>"</span>');
                    }

                    return data.text;
                }


            });


            $("#select2-client-"+rand).select2({
                ajax: {
                    url: '/dashboard/ajax/clients',
                    dataType: 'json',
                    delay : 250,

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear : true,
            });



            $("#select2-sales-invoice-"+rand).select2({
                ajax: {
                    url: function (params){
                        let client = $("#select2-client-"+rand).val();
                        return '/dashboard/ajax/invoices-grouped-by-clients?client='+client;
                    },
                    dataType: 'json',
                    delay : 250,

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear : true,
                templateResult: function (data) {
                    return data.text + (typeof data.html !== 'undefined' ? data.html  : '');
                },
                /*
                templateSelection: function (data) {
                    return data.text + data.html;
                },
                */
                escapeMarkup: function (markup) {
                    return markup; // allow HTML
                }
            });
        });
})