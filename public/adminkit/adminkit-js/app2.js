// LOADER
$('#loader')
    .hide() 
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    })
;


// SELECT2 Caller
$('.select2').select2();
$('.select2-parent-card').select2({
    dropdownParent: $('.card')
});

// SELECT2 Multiple
$('select[multiple]').select2({
    closeOnSelect: false,
});


var autonum_settings = {
    currencySymbol : ' ₱',
    decimalCharacter : '.',
    digitGroupSeparator : ',',
    emptyInputBehavior : 'null',
    modifyValueOnWheel: false,
};

var autonum_settings_simple = {
    currencySymbol : '',
    decimalCharacter : '.',
    digitGroupSeparator : ',',
    emptyInputBehavior : 'null',
    modifyValueOnWheel: false,
};




function autonum_init(){
    $(".autonum").each(function(){
        $(this).attr('autocomplete','off');
        new AutoNumeric(this, autonum_settings);
    });
}

function autonum_init_simple(){
    $(".autonum-simple").each(function(){
        $(this).attr('autocomplete','off');
        new AutoNumeric(this, autonum_settings_simple);
    });
}
function autonum_init_modal_new(btn){
    setTimeout(function () {
        $(btn.attr('data-bs-target')+" .autonum").each(function(){
            new AutoNumeric(this, autonum_settings);
        });
    },1000);
}

// Filter Form Submit Rule
$(document).ready(function($){
    autonum_init();
   $("#filter_form").submit(function() {
        // $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true;
    });
    // $("form").find( ":input" ).prop( "disabled", false );
    $(".tree_active").parents('.treeview').addClass('menu-open');
    $(".tree_active").parents('li').addClass('active');
    $(".tree_active").parents('.treeview-menu').slideDown();

    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        var $modalElement = this.$element;
        $(document).on('focusin.modal', function (e) {
            var $parent = $(e.target.parentNode);
            if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length
                // add whatever conditions you need here:
                &&
                !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
                $modalElement.focus()
            }
        })
    };

});



// Price Format
// $(".priceformat").priceFormat({
//     prefix: "",
//     thousandsSeparator: ",",
//     clearOnEmpty: true,
//     allowNegative: true
// });



// Input to Uppercase
$(document).on('blur', "input[data-transform=uppercase]", function () {
    $(this).val(function (_, val) {
        return val.toUpperCase();
    });
});


// iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
});


// Date Picker
$('.datepicker').each(function(){
    $(this).datepicker({
        autoclose: true,
        dateFormat: "mm/dd/yy",
        orientation: "bottom"
    });
});



// Time Picker
$('.timepicker').timepicker({
  showInputs: false,
  minuteStep: 1,
  showMeridian: true,
});



// Table Rule
$(document).on('change', 'select[id="action"]', function () {
  var element = $(this).children('option:selected');
  if(element.data('type') == '1' ){ 
    location = element.data('url');
  }
});


// Delete row in Dynamic Table
$(document).on("click","#delete_row" ,function(e) {
    $(this).closest('tr').remove();
});



function style_datatable(target_table){
    //Search Bar Styling
    $(target_table+'_filter input').css("width","300px");
    $(target_table+"_filter input").attr("placeholder","Press enter to search");
    $(target_table+"_wrapper .dt-buttons").addClass('col-md-4');
    $(target_table+"_wrapper .dataTables_length ").addClass('col-md-3');
    $(".buttons-html5").each(function(index, el) {
        $(this).addClass('btn-sm');
    });
}

function loading_btn(target_form){
    form_id = $(target_form[0]).attr('id');
    button = $("#"+form_id+" button[type='submit']");
    button_html = button.html();
    icon = button.children('i');
    old_icon_class = icon.attr('class');
    icon.attr('old-class',old_icon_class);
    icon.removeClass();
    icon.addClass('fa fa-spinner fa-spin');
    button.attr("disabled","disabled");
}

function errored(target_form, response){

    form_id = $(target_form[0]).attr('id');
    remove_loading_btn(target_form);


    if(response.status == 503){
        toast('error',response.responseJSON.message,'Error');
    }else if(response.status == 422){
        unmark_required(target_form);
        mark_required(target_form,response);
        toast('error',response.responseJSON.message,'Error');
    }else if(response.status == 413){
        notify('File too large.','danger');
    }else if(response.status == 515){
    }else{
        alert(response.responseJSON.message);
    }
}
function remove_loading_btn(target_form){
    form_id = $(target_form[0]).attr('id');
    button = $("#"+form_id+" button[type='submit']");
    button.removeAttr("disabled");

    icon = button.children('i');
    icon.removeClass();
    icon.addClass(icon.attr('old-class'));
}

function unmark_required(target_form){
    form_id = $(target_form[0]).attr('id');
    $("#"+form_id+" .has-error:not(.except)").each(function(){
        $(this).removeClass('has-error');
        $(this).children("span.warning-message").remove();

    });


    $("#"+form_id+" .is-invalid:not(.except)").each(function(){
        $(this).removeClass('is-invalid');
        $(this).children("span").last().remove();
    });

    $(".nav-tabs li").each(function () {
        $(this).removeClass('has-error');
    })
}

function mark_required(target_form, response){
    form_id = $(target_form[0]).attr('id');
    $.each(response.responseJSON.errors, function(i, item){
        let replaced = i.replaceAll('.','_');

        $("#"+form_id+" input[name='"+replaced+"']").parents('.file-input').addClass('has-error');
        if($("#"+form_id+" ."+replaced).hasClass('single') == true){
            $("#"+form_id+" ."+replaced).parent().append("<span class='warning-message small text-danger'> "+item+" </span>");
            $("#"+form_id+" ."+replaced).addClass('is-invalid');
            if($("#"+form_id+" ."+replaced).parents('.tab-pane').length){
                let parentTabPane = $("#"+form_id+" ."+replaced).parents('.tab-pane');
                let tab = parentTabPane.attr('id');

                $("a[href='#"+tab+"']").parent('li').removeClass('has-error');
                if(!$("a[href='#"+tab+"'] i").length){
                    $("a[href='#"+tab+"']").parent('li').addClass('has-error');

                }
            }
        }else{
            if($("#"+form_id+" ."+replaced).hasClass('minimal') == false){
                $("#"+form_id+" ."+replaced).append("<span class='warning-message small text-danger'> "+item+" </span>");
            }
        }
        $("#"+form_id+" ."+replaced).addClass('has-error');
        $("#"+form_id+" .form-control[name='"+replaced+"']").addClass('is-invalid');
    });
}


function wait_button(target_form){
    button = $(target_form+" button[type='submit']");
    button_html = button.html();

    button.html("<i class='fa fa-spinner fa-spin'> </i> Please wait");
    button.attr("disabled","disabled");
    Pace.restart();
}

function unwait_button(target_form , type){
    text = '';
    switch(type){
        case 'save' :
            text = "<i class='fa fa-save'> </i> Save";
            break;
        default:
            text = type;
            break;
    }
    button = $(target_form+" button[type='submit']");
    button.html(text);
    button.removeAttr('disabled');
}

function notify(message, type = 'success'){
    $.notify({
        // options
        message: message
    },{
        // settings
        type: type,
        z_index: 5000,
        delay: 3500,
        placement: {
            from: "top"
        },
        animate:{
            enter: "animate__animated animate__bounceIn",
            exit: "animated zoomOutRight"
        }
    });
}

function load_modal2(btn){
    $(btn.attr('data-bs-target')+" .modal-content").html(modal_loader_placeholder);
}

function load_offcanvas(btn){
    $(btn.attr('data-bs-target')+" .offcanvas-body").html(modal_loader_placeholder);
}


function populate_modal2(btn, response){
    target_modal = btn.attr('data-bs-target');
    $(target_modal +" #modal_loader_placeholder").fadeOut(200,function() {
        $(target_modal +" .modal-content").html(response);
        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });
        // $("ol.sortable").sortable();
    });
}

function populate_offcanvas(btn, response){
    target_modal = btn.attr('data-bs-target');
    $(target_modal +" #modal_loader_placeholder").fadeOut(200,function() {
        $(target_modal +" .offcanvas-body").html(response);
    });
}

function populate_modal2_error(response){
    if(response.status == 503){
        toast('error',response.responseJSON.message, 'Error:');
    }
    else if(response.status == 405){
        notify('Error: Request denied. Not enough privilege.', 'danger');
    }else{
        alert(response.responseJSON.message);
    }

}

function populate_offcanvas_error(response){
    if(response.status == 503){
        toast('error',response.responseJSON.message, 'Error:');
    }
    else if(response.status == 405){
        notify('Error: Request denied. Not enough privilege.', 'danger');
    }else{
        alert(response.responseJSON.message);
    }

}

function markTabs(form){
    let tabs = form.find('.nav-tabs').children('li');
    tabs.each(function () {
        $(this).removeClass('tab-error');
        let a = $(this).children('a');
        a.html(a.html().replace(' <i class="fa fa-exclamation-circle"></i>',''));
        let id = $(this).children('a').attr('href');
        let no_of_errors = $(id +' .has-error').length;
        if(no_of_errors > 0){
            $(this).addClass('tab-error');
            a.html(a.html()+' <i class="fa fa-exclamation-circle"></i>');
        }
    })
}

function succeed(target_form, reset,modal){
    form_id = $(target_form[0]).attr('id');
    if(reset == true){
        $("#"+form_id).get(0).reset();
        $element = $(target_form);
        $element.find('select').each(function (i, select) {
            var $select = $(select);

            // Make sure that the select has Select2.
            if($select.hasClass("select2-hidden-accessible")) {
                // Perform your action, e.g.:
                $("#"+$select.attr('id')).val('');
                $("#"+$select.attr('id')).trigger('change');
                // You can also use the console for debugging:
                // console.log($select);
            }
        });
    }

    if(modal == true){
        $(target_form).parents('.modal').modal('hide');
    }
    unmark_required(target_form);
    remove_loading_btn(target_form);
}

function wait_this_button(btn, text = '') {
    btn.attr('disabled','disabled');
    prent = btn.children('i').parent();
    btn.attr('old-i',prent.html());
    btn.html('<i class="fa fa-spin fa-spinner"></i> '+text);
}

function unwait_this_button(btn) {
    btn.removeAttr('disabled');
    prent = btn.children('i').parent();
    btn.html(btn.attr('old-i'));
}

function delete_data(slug,url){
    var btn = $("button[data='"+slug+"']");
    btn.parents('#'+slug).addClass('table-warning');
    url = url.replace('slug',slug);
    Swal.fire({
        title: 'Please confirm to delete permanently this data.',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-trash"></i> DELETE',
        confirmButtonColor: '#d73925',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            success: function (res) {
                if(res == 1){
                    btn.parents('#'+slug).addClass('danger');
                    btn.parents('#'+slug).addClass('animate__animated animate__zoomOutLeft');
                    toast('success','Data deleted successfully','Success');
                    setTimeout(function () {
                        btn.parents('#'+slug).parent('tbody').parent('table').DataTable().draw(false);
                    },500);

                }else{
                    btn.parents('#'+slug).removeClass('table-warning');
                    toast('danger','Error deleting data.','danger');
                }

            },
            error: function (res) {
                toast('error',res.responseJSON.message,'Error:');
                btn.parents('#'+slug).removeClass('table-warning');
            }
        });
            // Swal.fire('Saved!', '', 'success')
        }else{
            btn.parents('#'+slug).removeClass('table-warning');
        }
    })
}

function delete_data_secure(slug,url){
    var btn = $("button[data='"+slug+"']");
    btn.parents('#'+slug).addClass('table-warning');
    url = url.replace('slug',slug);
    Swal.fire({
        title: 'Permanently delete data?',
        input: 'password',
        html: 'Enter your password to proceed:',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-trash"></i> Delete',
        showLoaderOnConfirm: true,
        confirmButtonColor: '#dc3545',
        preConfirm: (password) => {
            return $.ajax({
                url : url,
                type: 'DELETE',
                data: { 'password':password},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res){
                    if(res == 1){
                        btn.parents('#'+slug).addClass('danger');
                        btn.parents('#'+slug).addClass('animate__animated animate__zoomOutLeft');
                        toast('success','Data deleted successfully','Success');
                        setTimeout(function () {
                            btn.parents('#'+slug).parent('tbody').parent('table').DataTable().draw(false);
                        },500);
                    }else{
                        btn.parents('#'+slug).removeClass('table-warning');
                        toast('danger','Error deleting data.','danger');
                    }
                }
            })
                .catch(error => {
                    console.log(error);
                    Swal.showValidationMessage(
                        'Error : '+ error.responseJSON.message,
                    );
                    btn.parents('#'+slug).removeClass('table-warning');
                })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (!result.isConfirmed) {
            btn.parents('#'+slug).removeClass('table-warning');
        }
    })

}


const formatToCurrency = amount => {
    return "" + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
};

$("body").on("click",".add_button",function () {
    let btn = $(this);
    $.ajax({
        url : btn.attr('uri'),
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (res) {
            $(btn.attr('data-bs-target')+' tbody').append(res);
        },
        error: function (res) {
        }
    })
});

$("body").on("click",".remove_row_btn",function () {
    $(this).parents('tr').remove();
})



function toast(type,message,heading = null,hideAfter = 5000) {
    $.toast({
        text: message, // Text that is to be shown in the toast
        heading: heading, // Optional heading to be shown on the toast
        icon: type, // Type of toast icon
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: true, // Boolean value true or false
        hideAfter: hideAfter, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
        textAlign: 'left',  // Text alignment i.e. left, right or center
        loader: false,  // Whether to show loader or not. True by default
        loaderBg: '#9EC600',  // Background color of the toast loader
    });
}

function makeId(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
    }
    return result;
}

function sanitizeAutonum(number){
    number = number.replaceAll(' ','');
    number = number.replaceAll('₱','');
    number = number.replaceAll(',','');
    number = parseFloat(number);
    if (isNaN(number)) {
        return 0;
    }else{
        return number;
    }
}

function makeSubmenuActive(url){
    let activePath = url;
    let targetA = $("a[href='"+activePath+"']");
    targetA.parent('li').addClass('active');
    targetA.parents('.treeview').addClass('menu-open');
    targetA.parents('.treeview-menu').css('display','block');
}

$("#img_box").click(function (){
    $(this).fadeOut();
})
$("body").on("click",".gj-imagebox",function (){
    $("#img_box span").show();
    $("#img_box img").hide();
    $("#img_box").fadeIn();
    $("#img_box img").attr('src',$(this).attr('original'));
})

$("#img_box img").on("load",function (){
    $("#img_box span").hide();
    $("#img_box img").show();
})


function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    let user = getCookie("username");
    if (user !== "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user !== "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}


function initializeAutonumByClass(className){
    className = className.replace('.','');
    $("."+className).each(function(){
        new AutoNumeric(this, autonum_settings);
    });
}



$("body").on("click",".print-btn-dialog",function (){
    let href = $(this).attr('href');
    window.open(href, "popupWindow", "width=1200, height=600, scrollbars=yes");
});



