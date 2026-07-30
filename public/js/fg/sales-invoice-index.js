$("body").on('click','.cancel-invoice-btn',function (){
    let btn = $(this);
    let action = btn.data('action');
    let uri = 'sales-invoice/slug?cancel';
    uri = uri.replace('slug',btn.attr('data'));
    Swal.fire({
        title: 'Are you sure?',
        text: 'This will '+action.toUpperCase()+' an invoice',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: () => {
            return $.ajax({
                url : uri,
                data : {
                    action : action,
                },
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
        }).then(function (res){
                return res; // pass to result.value
            }).catch(function (xhr) {
                Swal.showValidationMessage(
                    xhr.responseJSON?.message || 'Request failed'
                );
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Success!', 'Action completed.', 'success');
            active = result.value.uuid;
            projectExpenseLiquidationTbl.draw(false);
        }
    });
})