/* jshint esversion: 6 */
let autonums = [];
function compute($form){
    let distribution = $form.find('#distribution-table input[name$="[amount]"]');
    let checks = $form.find('#checks-table input[name$="[amount]"]');
    let totalChecks = 0;
    checks.each(function (){
        totalChecks = totalChecks + sanitizeAutonum($(this).val());
    })
    autonumGlobalInstances['total_check'].set(totalChecks);
    let totalCash = autonumGlobalInstances['total_cash'].getNumber();
    let cwt = autonumGlobalInstances['cwt'].getNumber();
    let totalAmount = totalChecks + totalCash;
    autonumGlobalInstances['total_amount'].set(totalAmount);
    autonumGlobalInstances['total_paid'].set(totalAmount - cwt);
}

$("body").on("keyup",".compute",function (){
    compute($(this).closest('form'));
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
            autonums[rand] = new AutoNumeric('.autonum-'+rand, autonum_settings_simple);
            $("#select2-banks-"+rand).select2({
                ajax: {
                    url: '/dashboard/ajax/banks',
                    dataType: 'json',
                    delay : 250,

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear : true,
            });
        });
})