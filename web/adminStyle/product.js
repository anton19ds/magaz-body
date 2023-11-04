$(document).on('change', '#product-name', function (e) {
    var val = $(this).val();
    var url = $("#urlSite").val();
    word = translit(val);

    $.post('/admin/product/set-url', { word: word, url: url }, Success);
    function Success(data) {
        var parse = JSON.parse(data);
        $('#product-link').val(parse.link);
        $('.linkUrl').html(parse.obj);
    }
});




