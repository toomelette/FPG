$(".report-form").submit(function (e){
    e.preventDefault();
    let form = $(this);
    let route = form.attr('target');
    let params = form.serialize();
    let target = route+'?'+params;
    let targetExcel = route+'?excel=true&'+params;
    let iframe = form.closest('div').find('iframe');
    let excelBtn = form.closest('div').find('.excel-btn');
    excelBtn.removeClass('hide-this');
    excelBtn.attr('href',targetExcel);
    iframe.attr('src',target);
})

$(".print-btn").click(function (){
    let btn = $(this);
    let iframe = btn.parent('div').parent('div').find('iframe');
    iframe.get(0).contentWindow.print();
})
