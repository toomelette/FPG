let autonums = [];

function compute($tr){
    let id = $tr.data('id');
    let qty = $tr.find('input[name*="qty"]').val();
    let unitCost = $tr.find('input[name*="unit_cost"]').val();
    qty = sanitizeAutonum(qty);
    unitCost = sanitizeAutonum(unitCost);
    $tr.find('input[name*="amount"]').val($.number(qty*unitCost,2));
    let $table = $tr.closest('table');
    computeTable($table);
}

function computeTable($table){
    let grandTotal = 0;
    $table.find('input[name*="amount"]').each(function (){
        let totalCost = sanitizeAutonum($(this).val());
        grandTotal = grandTotal + totalCost;
    });
    //autonums['totalAmountDue'].set(grandTotal);
}



$(document).ready(function (){

    //autonums['totalAmountDue'] = new AutoNumeric('.autonum-total-amount-due',autonum_settings_simple);
})

$("body").on("change keyup",'.compute',function(){
    compute($(this).closest('tr'));
});
$("body").on("click",".remove_row_btn",function (){
    computeTable($("#details-table"));
})