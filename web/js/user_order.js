$(document).on('click', '.view-product', function(e){
    e.preventDefault();
    var uuid = $(this).data('uuid');
    var lang = $(this).data('lang');
    $.post('/user/default/modal-show', {uuid: uuid, lang: lang}, function(data){
        $('#view_product .modal-body').html(data);
        $('#view_product').modal('show');
    });
});

$(document).on('click', '.step', function(e){
    document.location = document.location +"/"+$(this).data('id');
});
$('div').each(function(e){
    $(this).attr('contenteditable', false);
});