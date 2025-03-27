$(document).ready(function (e) {
    $('.send-promocod').on('click', function (e) {
        e.preventDefault();
        var promocode_partner = $('.promocode_partner').val();
        $.post('/cart/add-promocode', { promocode_partner: promocode_partner }, function Success(data) {
            if (data.message) {
                // $('.tm-data').html(data.data);

                // $('.text-template').html(data.type);
                // $('.template-alert').css('left', '0%');
                // setTimeout(function TmpAlertHide() {
                //     $('.template-alert').css('left', '-100%');
                // }, 4000);
                if ($('#pjax-cart').length) {
                    $.pjax.reload({ container: "#pjax-cart", replace: true, async: false });
                }
                if ($('#pjax-cart-min').length) {
                    $.pjax.reload({ container: "#pjax-cart-min", replace: true, async: false });
                }

            } else {
                $('.promocode_partner').closest('.set_data').addClass('error');
                return false;
            }
        })
    })
});

$(function () {
    $('.card').each(function (e) {
        if ($(this).find('.main-image-product').length) {
            $(this).find('.list-image').css('display', 'none');
        }
    });
    $('.card')
        .on('mouseenter', function () {
            $(this).find('.card-dropdown').css('display', 'block');
            if ($(this).find('.main-image-product').length) {
                $(this).find('.list-image').css('display', 'block');
                $(this).find('.main-image-product').css('display', 'none');
            } else {

                if ($(this).find('.list-image li:nth-child(2)').length) {
                    $(this).find('.list-image li:first-child').css('display', 'none');
                    $(this).find('.list-image li:nth-child(2)').css('display', 'block');
                }
            }
        })
        .on('mouseleave', function () {
            if ($(this).find('.main-image-product').length) {
                $(this).find('.list-image').css('display', 'none');
                $(this).find('.main-image-product').css('display', 'block');
            }else{
                if ($(this).find('.list-image li:nth-child(2)').length) {
                    $(this).find('.list-image li:first-child').css('display', 'flex');
                    $(this).find('.list-image li:nth-child(2)').css('display', 'none');
                }
            }
            $(this).find('.card-dropdown').css('display', 'none');

            //$(this).find('.card-img img').css('opacity', '1');
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

$('.startListData').on('change', function (e) {
    var val = $(this).val();
    $('.startListData').each(function (e) {
        if ($(this).val() < val) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
    })
})
$(document).on('click', '.no_opened',function(){
    $(this).removeClass('no_opened').addClass('opened');
});

$(document).on('click', '.opened .item',function(){
    let parent =  $(this).parents('.quantity_good_abs');
    let id = parent.data('id');
    $('.prd-'+$(this).data('id')).html($(this).data('ser')+" "+$(this).data('code'));
    $('.add-to-cart[data-id="'+id+'"]').attr('data-count', $(this).data('value'));
    parent.children('.item').removeClass('active');
    let val = $(this).attr('data-value');
    parent.next('input').val(val);
    $(this).addClass('active');
    parent.removeClass('opened').addClass('no_opened');
    $('.variable_package__item').removeClass('active');
    $('.variable_package__item[data-value="' + val + '"]').addClass('active');
});

// СТРАНИЦА ТОВАРА

$('.variable_package__item').click(function(){
    let data = $(this).attr('data-value');
    $('.quantity_good_abs .item').removeClass('active');
    $('.quantity_good_abs .item[data-value="' + data + '"]').addClass('active');

    $('.variable_package__item').removeClass('active');
    $('#add_cart_product').attr('data-count', data);
    $(this).addClass('active');
    $('.set-pr-st').html($(this).find('.price_count').attr('data-price'));
});

// Звездочки в форме рейтинга

$('.choose_rate__items.no_checked span').on( "mouseenter", function() {
    let rate = $(this).attr('data-rating');
    $('.choose_rate__items.no_checked span').each(function(){
       if (Number($(this).attr('data-rating')) <= rate) {
           $(this).addClass('active');
       }
    });
}).on( "mouseleave", function() {
    $('.choose_rate__items.no_checked span').removeClass('active');
} );

$(document).on('click', '.choose_rate__items span' ,function(){
    let rate = $(this).attr('data-rating');
    $(this).closest('.choose_rate__items').find('span').removeClass('active');
    $('.choose_rate__items span').each(function(){
        if (Number($(this).attr('data-rating')) <= rate) {
            $(this).addClass('active');
        }
    });
    $('.choose_rate__items').removeClass('no_checked');
    $('input[name="count_rate_review"]').val(rate);
});

// Слайдер

$('.product_gallery__top').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    infinite: false,
    fade: true,
    asNavFor: '.product_gallery__bottom'
});
$('.product_gallery__bottom').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    infinite: false,
    arrows: false,
    asNavFor: '.product_gallery__top',
    focusOnSelect: true
});

$('#submitSendR').on('click', function(e){
    e.preventDefault();
    if($('input[name="count_rate_review"]').val() === '') {
        $('.add_review_form').addClass('error');
    }else{
        var data = $('#addRewersS').serializeArray();
        $.post('/load-reviews', {'data' : data}, function Success(result){
            if(result)
            $('.riview-alert').css('display', 'block');
            $('#text_review').val('');
            $('.choose_rate__items span').removeClass('active');
            $('input[name="count_rate_review"]').val('');
        })
    }
});



 
