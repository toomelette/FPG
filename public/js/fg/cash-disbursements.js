/* jshint esversion: 6 */
function compute(table){
    let totalDebit = 0;
    let totalCredit = 0;
    table.find("tbody tr").each(function (){
        let debit = $(this).find('input[for="debit"]').val();
        let credit = $(this).find('input[for="credit"]').val();
        debit = sanitizeAutonum(debit);
        credit = sanitizeAutonum(credit);
        totalDebit = totalDebit + debit;
        totalCredit = totalCredit + credit;
    });
    table.find(".total-debit").html($.number(totalDebit,2));
    table.find(".total-credit").html($.number(totalCredit,2));
}

$("body").on("change keyup","input[class*='autonum-']",function (){
    let table = $(this).closest('table');
    compute(table);
});




$("body").on("click",".remove-row-btn",function (){
    let table = $(this).closest('table');
    let tr = $(this).closest('tr');
    let trId = tr.attr('data-id');
    delete subsidiaryLedgers[trId];
    tr.remove();
    compute(table);
});


$("body").on("click",".add-btn",function (){
    let btn = $(this);
    let table = btn.parents('table');
    let templateId = btn.attr('template');
    let rand = makeId(5);
    let template = $(templateId).html().replaceAll('rand',rand);
    subsidiaryLedgers[rand] = [];
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




$("body").on("click",".subsidiary-ledger-btn",function (e){
    let tr = $(this).closest('tr');
    let trId = tr.attr('id');
    let id = tr.attr('data-id');
    let select2AccountCode = tr.find('select[name*="[account_code]"]');
    let subsidiaryLedgerModal = $("#subsidiary-ledgers-modal");
    let subsidiaryLedgerTable = subsidiaryLedgerModal.find('#subsidiary-ledger-table');
    subsidiaryLedgerModal.find('#title').html(select2AccountCode.select2('data')[0].text);
    subsidiaryLedgerModal.attr('data-account',id);
    subsidiaryLedgerTable.find('tbody').html('');


    let table = subsidiaryLedgerTable;
    compute(table);
    $.each(subsidiaryLedgers[id],function (i,row){
        let rand = row.id;
        let template = $("#subsidiary-ledger-template").html();
        template = template.replaceAll('rand',rand);
        table.find('tbody')
            .append(template)
            .ready(function (){
                autonumGlobalInstances[rand+'-debit'] = new AutoNumeric('.autonum-debit-'+rand, autonum_settings_simple);
                autonumGlobalInstances[rand+'-credit'] = new AutoNumeric('.autonum-credit-'+rand, autonum_settings_simple);

                if(row.debit !== 0){
                    autonumGlobalInstances[rand+'-debit'].set(row.debit);
                }
                if(row.credit !== 0){
                    autonumGlobalInstances[rand+'-credit'].set(row.credit);
                }

                $("#select2-accounts-"+rand).select2({
                    ajax: {
                        url: function (){
                            let parentAccountCode = select2AccountCode.val();
                            return '/dashboard/ajax/subsidiary-account-codes?parent_account_code='+parentAccountCode;
                        },
                        dataType: 'json',
                        delay : 250,

                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    placeholder: "Select",
                    allowClear : true,
                    dropdownParent : $("#subsidiary-ledgers-modal"),
                });
                let defaultId = row.account_code;
                let defaultText = row.account_text;
                let option = new Option(defaultText, defaultId, true, true);
                $("#select2-accounts-" + rand).append(option).trigger('change');
                compute(table);
            });
    })
});


$("body").on("click",".add-sl-btn",function (){
    let btn = $(this);
    let table = btn.parents('table');
    let templateId = btn.attr('template');
    let rand = makeId(5);
    let template = $(templateId).html().replaceAll('rand',rand);
    let parentRowId = $(this).closest('.modal').attr('data-account');
    let parentSelect = $("select[name='entries["+parentRowId+"][account_code]']");

    table.find('tbody')
        .append(template)
        .ready(function (){
            autonumGlobalInstances[rand] = new AutoNumeric('.autonum-debit-'+rand, autonum_settings_simple);
            autonumGlobalInstances[rand] = new AutoNumeric('.autonum-credit-'+rand, autonum_settings_simple);

            $("#select2-accounts-"+rand).select2({
                ajax: {
                    url: function (){
                        let parentAccountCode = parentSelect.val();
                        return '/dashboard/ajax/subsidiary-account-codes?parent_account_code='+parentAccountCode;
                    },
                    dataType: 'json',
                    delay : 250,

                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: "Select",
                allowClear : true,
                dropdownParent : $("#subsidiary-ledgers-modal"),
            });
        });
})

$("#subsidiary-ledger-form").submit(function (e){
    e.preventDefault();
    let form = $(this);
    let modal = form.closest('.modal');
    let journalEntryId = modal.attr('data-account');
    let data = form.serializeArray();

    let formData = Object.fromEntries(
        form.serializeArray().map(item => [item.name, item.value])
    );

    let input = formData;
    let result = [];

    for (let [key, value] of Object.entries(input)) {

        let match = key.match(/^subsidiary_ledger\[(.*?)\]\[(.*?)\]$/);
        if (!match) continue;

        let rowId = match[1];
        let field = match[2];

        // 🔥 find or create row
        let row = result.find(r => r.id === rowId);

        if (!row) {
            row = { id: rowId };
            result.push(row);
        }

        // 🔥 debit / credit sanitizing
        if (field === 'debit' || field === 'credit') {
            row[field] = sanitizeAutonum(value);
        }
        else {
            row[field] = value;
        }

        // 🔥 Select2 text for account_code
        if (field === 'account_code') {
            let select = $(`[name="${key}"]`);

            let text = select.select2('data')[0]?.text
                || select.find('option:selected').text();

            row['account_text'] = text;
        }
    }
    $(form).parents('.modal').modal('hide');
    subsidiaryLedgers[journalEntryId] = result;
})

$('#subsidiary-ledgers-modal').on('hidden.bs.modal', function (event) {
    let id = $(this).attr('data-account');
    let totalSubsidiaries = subsidiaryLedgers[id].length === 0 ? '' : subsidiaryLedgers[id].length ;
    $("#journal-entries-"+id).find('.counter').html(totalSubsidiaries);
});