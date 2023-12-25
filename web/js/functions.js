$(document).ready(function (e) {
    $('.send-promocod').on('click', function (e) {
        e.preventDefault();
        var promocode_partner = $('.promocode_partner').val();
        $.post('/cart/add-promocode', { promocode_partner: promocode_partner }, function Success(data) {
            if (data.message) {
                $('.tm-data').html(data.data);
                
                $('.text-template').html(data.type);
                    $('.template-alert').css('left', '0%');
                    setTimeout(function TmpAlertHide() {
                        $('.template-alert').css('left', '-100%');
                    }, 4000);
                    if($('#pjax-cart').length){
                        $.pjax.reload({ container: "#pjax-cart", replace: true, async: false});
                    }
                    if($('#pjax-cart-min').length){
                        $.pjax.reload({ container: "#pjax-cart-min", replace: true, async: false});
                    }
                
            } else {
                alert('Промокод не найден');
            }
        })
    })
});
// $(document).on('pjax:complete', function (event, data, status, xhr, options) {
//     if($('#up-min-cart').length){
//         $.pjax.reload({ container: '#up-min-cart', replace: true, async: false });
//     }
// });


$(function () {
    $('.card')
        .on('mouseenter', function () {
            $(this).find('.card-dropdown').css('display', 'block');
            var s = 0;
            $(this).find('.card-img img').each(function(index, item){
                if(index == 1){
                    $(this).css('opacity', '0');
                };
            });
            
            if(s != 0 ){
                $(this).find('.card-img').find('img:first-child').css('opasity', '0');
            }
            // $(this).find('.card-dropdown').css('display', 'block');

        })
        .on('mouseleave', function () {
            $(this).find('.card-dropdown').css('display', 'none');
            $(this).find('.card-img img').css('opacity', '1');
        });

    $('.quantity')
        .on('click', function (e) {
            console.log(e.target.tagName);
            if ($(this).hasClass('open')) {
                $(this).find('.quantity__item').css('display', 'none');
                $(this).removeClass('open');

                $('.quantity__item').removeClass('active');
                if (e.target.tagName == "SPAN") {
                    $(e.target).closest('.quantity__item').addClass('active').css('display', 'block');
                } else {
                    $(e.target).addClass('active').css('display', 'block');
                }

            } else {
                $(this).find('.quantity__item:not(.active)').css('display', 'block');
                $(this).addClass('open');
            }


        });
});
$('.chekbox').on('click', function (e) {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');

    } else {
        $(this).addClass('active');
    }
});

$('.startListData').on('change', function(e){
    var val = $(this).val();
    $('.startListData').each(function(e){
        if($(this).val() < val){
            $(this).siblings('label').addClass('active');
        }else{
            $(this).siblings('label').removeClass('active');
        }
    })
})