/* jshint esversion: 6 */
function compute(){
    let totalDebit = 0;
    let totalCredit = 0;
    $("#entries-table tbody tr").each(function (){
        let debit = $(this).find('input[for="debit"]').val()
        let credit = $(this).find('input[for="credit"]').val()
        debit = sanitizeAutonum(debit);
        credit = sanitizeAutonum(credit);
        totalDebit = totalDebit + debit;
        totalCredit = totalCredit + credit;
    });
    $("#total-debit").html($.number(totalDebit,2));
    $("#total-credit").html($.number(totalCredit,2));
}

$("body").on("change keyup","#entries-table input[class*='autonum-']",function (){
    compute();
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
            autonumGlobalInstances[rand] = new AutoNumeric('.autonum-debit-'+rand, autonum_settings_simple);
            autonumGlobalInstances[rand] = new AutoNumeric('.autonum-credit-'+rand, autonum_settings_simple);

            $("#select2-accounts-"+rand).select2({
                ajax: {
                    url: '/dashboard/ajax/account-codes',
                    dataType: 'json',
                    delay : 250,

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear : true,
            });
        });
})

$("body").on("click",".remove_row_btn",function (){
    compute();
});