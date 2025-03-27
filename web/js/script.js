$(document).on('click', '.ordering_main__steps span a', function (e) {
    e.preventDefault();
})

document.querySelectorAll('.list-option').forEach(b => b.addEventListener('click',
    function (e) {
        this.classList.toggle('rotate');
        sub = this.nextElementSibling;
        sub.classList.toggle('view');
    }
));

$('.cart_finish__promocodes .set_data input, .ordering_form_section__item-inp input').each(function () {
    if ($.trim($(this).val().length) > 0) {
        $(this).prev('label').animate({
            //         'top': '8px',
            //         'font-size': '11px'
        }, 100);
    }
});

$(document).on('focus', '#pjax-cart .cart_finish__promocodes .set_data input, .ordering_form_section__item-inp input', function () {
    $(this).prev('label').animate({
        'top': '8px',
        'font-size': '11px'
    }, 100);
});

$('#pjax-cart .cart_finish__promocodes .set_data input, .ordering_form_section__item-inp input').focusout(function () {
    if ($.trim($(this).val().length) == 0) {
        $(this).prev('label').animate({
            'top': '14px',
            'font-size': '16px'
        }, 100);
    }
});

$('#pjax-cart-min .cart_finish__promocodes .set_data input,#pjax-cart-min .ordering_form_section__item-inp input').focus(function () {
    $(this).prev('label').animate({
        'top': '3px',
        'font-size': '10px'
    }, 100);
});

$('#pjax-cart-min .cart_finish__promocodes .set_data input,#pjax-cart-min .ordering_form_section__item-inp input').focusout(function () {
    if ($.trim($(this).val().length) == 0) {
        $(this).prev('label').animate({
            'top': '10px',
            'font-size': '14px'
        }, 100);
    }
});
$('#pjax-cart-min .block-ert').on('click', function (e) {
    $(this).find('input[type="text"]').focus();
    $(this).find('label').animate({
        'top': '3px',
        'font-size': '10px'
    }, 100);
});

$(document).ready(function () {

    $(document).on('click', '.add-to-cart', function (e) {

        parent.postMessage({
            scroll: 'scroll',
        }, '*');
        var top = 0;
        var height = 0;
        window.addEventListener('message', function (e) {
            top = e.data.top;
            if (e.data.height) {
                height = e.data.height;
            }
        })
        e.preventDefault();
        var lang = $('#tagLang').val();
        var $yiibtn = $(this);
        $.post("/cart/add-cart", {
            id: $yiibtn.data('id'),
            count: $yiibtn.attr('data-count'),
            lang: lang
        },
            function Success(data) {
                if (data.message) {
                    if ($('#pjax-cart-modal').length) {
                        $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
                    }
                    if ($('#pjax-cart').length) {
                        $.pjax.reload({ 'container': '#pjax-cart', 'replace': true, 'push': false });
                        return false;
                    }
                    // if ($('#end-resutl').length) {
                    //     $('#end-resutl').html(data.cartTotal);
                    // }
                    console.log(data);
                } else {
                    console.log('info');
                    showAlert(data.info);
                }

                // if (data.message) {
                //     console.log(data);

                if ($('#pjax-cart-modal').length) {
                    $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
                }
                if ($('#pjax-cart').length) {
                    $.pjax.reload({ 'container': '#pjax-cart', 'replace': true, 'push': false });
                    return false;
                }
                if ($('#end-resutl').length) {
                    $('#end-resutl').html(data.cartTotal);
                }
                // } else {

                // }

                $('.cart-wraper .cart').css({
                    'top': top + 'px',
                    'height': height + 'px'
                });
            })
    });
});



function showAlert(text) {


    $('.tm-data').html(text);
    $('.template-alert').css('left', '10px');

    setTimeout(function TmpAlertHide() {
        $('.template-alert').css('left', '-100%');
    }, 4000);
}


$(document).on('pjax:complete', function (event, data, status, xhr, options) {
    varHe = document.getElementById('topBody');
    parent.postMessage({
        he: varHe.scrollHeight,
    }, '*');
    if ($('.cart-modal').length) {
        parent.postMessage({
            overflowY: "hidden",
        }, '*');
        $('html').css('overflow-y', 'hidden');
        $('.cart-modal').css('display', 'block');
        $('.cart-modal .cart').animate({
            right: "0%",
        }, 200, function () {
        });
    }


});







$(document).on('click', '.close-cart', function (e) {
    e.preventDefault();
    $('html').css('overflow-y', 'auto');
    parent.postMessage({
        overflowY: "auto",
    }, '*');

    $('.cart-modal .cart').animate({
        right: "-100%",
    }, 200, function () {
        $('.cart-modal').css('display', 'none');
    });

});

$(document).on('click', '.open-cart', function (e) {
    e.preventDefault();
    $('.cart-modal .cart').animate({
        right: "0%",
    }, 200, function () {
        $('.cart-modal').css('display', 'block');
    });
});

$('.btn-order-save').on('click', function (e) {
    e.preventDefault();
    var stat = true;
    var form = $('#order-form');
    form.find('.requered').each(function (e) {
        $(this).removeClass('em-input');
        if ($(this).val() == '') {
            stat = false;
            $(this).addClass('em-input');
        }
    });
    if (stat) {
        form.submit();
    }
});

$('.requered').keyup(function (e) {
    if ($(this).hasClass('em-input')) {
        $(this).removeClass('em-input');
    }
})
$(document).on('click', '.adress-item', function (e) {
    $('.adress-item').removeClass('active');
    $(this).addClass('active');

    $('.chekerAdress').attr("checked", false);
    $(this).find('input[type="checkbox"]').attr("checked", "checked");

    $('.new_adress').removeClass('active');
    $('.slider_adress').slideUp();
});

$(document).on('click', '.set_newadress', function (e) {
    $('.adress-item').removeClass('active');
    $(this).addClass('active');
    $('.chekerAdress').attr("checked", false);
    $(this).find('input[type="checkbox"]').attr("checked", "checked");
    $('.slider_adress').slideDown();
})

$(document).on('change', '.type-payment', function (e) {
    $('.elem-payment').removeClass('active');
    $(this).closest('.elem-payment').addClass('active');
})
$(document).on('click', '.col-colect', function (e) {
    $(".col-colect").removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '.col-param-cart-data .plus', function (e) {
    var id = $(this).data('id');
    $.post('/cart/plus-tov', { id: id }, function (data) {
        $(".summ-m[data-id='" + id + "']").html(data.setTovar);
        $(".col-elem[data-id='" + id + "']").html(data.count);
        $(".prise-sum-s").html(data.summ);
    });
});

$(document).on('click', '.col-param-cart-data .minus', function (e) {
    var id = $(this).data('id');
    $.post('/cart/minus-tov', { id: $(this).data('id') }, function (data) {
        $(".summ-m[data-id='" + id + "']").html(data.setTovar);
        $(".col-elem[data-id='" + id + "']").html(data.count);
        $(".prise-sum-s").html(data.summ);
    });
});

$(document).on('click', '.check-promocod', function (e) {
    var promocod = $("#promocod").val();
    $.post('/cart/promocod', { promocod: promocod }, function (data) {
        $(".curenncy .result").after(data.dataStr);
        $(".end-pay .prise-sum-s").html(data.result);
    })
});

$(document).on('click', '.menu-user', function (e) {
    if ($(this).hasClass('active')) {
        $('#menuUser').slideUp();
        $(this).removeClass('active');
    } else {
        $('#menuUser').slideDown();
        $(this).addClass('active');
    }
})


$(document).on('click', '.del-in-cart', function (e) {
    var id = $(this).data('id');
    $.post('/cart/remove-tovar-from-cart', { id: id }, function (data) {

        $.pjax.reload({ 'container': '#list-tovar', 'replace': false });
    })
})


$(document).on('click', '.btn-reg', function (e) {
    e.preventDefault();

    var email = $('#regEmail').val();
    if (email != '') {
        $.post('/login/register', { email: email }, function (data) {
            var url = "/" + $('#tagLang').val() + "/" + "user";
            // document.location = "/" + $('#tagLang').val() + "/" + "user";
            alert(url);
        });
    }
});



$(document).on('click', '.newPassGen', function (e) {
    e.preventDefault();
    $('#new-pass').modal('show');
})

$(document).on('click', '.img_prod_list .elem', function (e) {
    var img = $(this).find('img').attr('src');
    $('.img-product').find('img').attr('src', img);
});


$(document).on('click', '.ser-list img', function (e) {
    var clone = $(this).clone();
    $('.img-body').html(clone);
    $('#image-modal').modal('show');
})

$(document).on('click', '.plus-tov-cart', function (e) {
    e.preventDefault();
    $.post('/cart/plus-tov', { id: $(this).data('id') }, function Success(data) {
        console.log(data);
        if (data.message) {
            if ($('#pjax-cart-modal').length) {
                $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
            }

            if ($('#pjax-cart').length) {
                $.pjax.reload({ container: '#pjax-cart', replace: true, async: false });
                return false;
            }

            if ($('#pjax-cart-min').length) {
                $.pjax.reload({ container: '#pjax-cart-min', replace: true, async: false });
                return false;
            }
            if ($('#end-resutl').length) {
                $('#end-resutl').html(data.cartTotal);
            }
            return false;
        } else {
            alert('2');
        }
    });
});
$(document).on('click', '.minus-tov-cart', function (e) {
    e.preventDefault();
    if ($(this).hasClass('active')) {
        $.post('/cart/minus-tov', { id: $(this).data('id') }, function Success(data) {
            if (data.message) {
                if ($('#pjax-cart').length) {
                    $.pjax.reload({ 'container': '#pjax-cart' });
                    return false;
                }
                if ($('#pjax-cart-modal').length) {
                    $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
                }
                if ($('#end-resutl').length) {
                    $('#end-resutl').html(data.cartTotal);
                }
                if ($('#pjax-cart-min').length) {
                    $.pjax.reload({ 'container': '#pjax-cart-min', 'replace': true });
                    return false;
                }
                if ($('#end-resutl').length) {
                    $('#end-resutl').html(data.cartTotal);
                }
                return false;
            }
        });
    }
});

$(document).on('click', '.delete-tov-cart', function (e) {
    $.post('/cart/remove-tovar-from-cart', { id: $(this).data('id') }, function Success(data) {
        if (data) {
            if ($('#pjax-cart').length) {
                $.pjax.reload({ container: '#pjax-cart', replace: true, async: false });
            }
            if ($('#pjax-cart-modal').length) {
                $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
            }
            if ($('#pjax-cart-min').length) {
                $.pjax.reload({ container: '#pjax-cart-min', replace: true, async: false });
                return false;
            }
        }
    })
})

$('#form-order input').on('change keyup', function () {
    if ($.trim($(this).val()) !== '') {
        if ($(this).hasClass('err')) {
            $(this).css({
                'border': '1px solid #D9D9D9',
                'box-shadow': 'none'
            });
            $(this).next('.form_pers-data__inputs-error').hide(0);
            $(this).removeClass('err')
        }

    }
    // if ($.trim($(this).val()) !== '') {
    //     $(this).css({
    //         'border': '1px solid #D9D9D9',
    //         'box-shadow': 'none'
    //     });
    //     $(this).next('.form_pers-data__inputs-error').hide(0);
    // }
});

$(document).on('click', '#send-form', function (e) {
    e.preventDefault();
    var arr = ['email', 'phone', 'country', 'postcode', 'city', 'area', 'street', 'house', 'surname', 'name', 'lastname'];
    var form = $('#form-order').serializeArray();
    //console.log(form);
    var currensy = $('#currensy').val();
    var set = true;
    var lang = $(this).data("lang");
    var link = $(this).data("link");
    $.each(form, function (index, item) {
        if (arr.includes(item.name)) {
            if ($.trim(item.value) === '') {
                $('input[name="' + item.name + '"]').css({
                    'border': '1px solid #D43D47',
                    'box-shadow': '0 0 0 1px #D43D47'
                });
                $('input[name="' + item.name + '"]').next('.form_pers-data__inputs-error').show(0);
                $('input[name="' + item.name + '"]').addClass('err');
                $('input[name="' + item.name + '"]').closest('.ordering_form_section__item').addClass('error');

                $('select[name="' + item.name + '"]').css({
                    'border': '1px solid #D43D47',
                    'box-shadow': '0 0 0 1px #D43D47'
                });
                $('select[name="' + item.name + '"]').next('.form_pers-data__inputs-error').show(0);
                $('select[name="' + item.name + '"]').addClass('err');
                $('select[name="' + item.name + '"]').closest('.ordering_form_section__item').addClass('error');

                set = false;
            }
        }
    });

    if (set) {
        $.ajax({
            type: "POST",
            url: "/cart/send-order",
            data: { 'data': form, 'comment': $('#comment').val() },
            success: function (data) {

                //alert(data);
                // console.log(data);
                if (data.message == 'user-valid' || data.message == 'user-new') {
                    parent.postMessage({
                        lang: lang,
                        link: link,
                    }, "*");
                    document.location = "/" + currensy + "/delivery";
                } else if (data.message == 'user-invalid') {
                    $('#dataAlertDiss').show(0);
                } else {
                    console.log(data);
                }
            }
        });
    }
})


$('.set-input-data').keyup(function (e) {
    $(this).removeClass('input-invalid');
});

// $(document).on('click', '#send-pay', function (e) {
//     e.preventDefault();
//     var form = $('#form-payment').serializeArray();
//     var currensy = $('#currensy').val();
//     $.ajax({
//         type: "POST",
//         url: "/cart/send-pay",
//         data: { form, currensy },
//         success: function (data) {
//             if (data) {
//                 //console.log(data);
//                 document.location = "/" + currensy + "/final-payment";
//             } else {
//                 alert('Укажите тип оплаты');
//             }
//         }
//     });
// })



let currentUrl = window.location.pathname;
if ($('.basket-nav__item[data-url="' + currentUrl + '"]').length) {
    let urlHref = $('.basket-nav__item[data-url="' + currentUrl + '"]').data('step');
    $('.basket-nav__item').each(function (index, item) {
        if ($(this).data('step') <= urlHref) {
            $(this).addClass('active');
        }
    });
}
$(document).on('click', '#send-log-order', function (e) {
    e.preventDefault();
    //var arr = ['email', 'phone', 'country', 'postcode', 'city', 'area', 'street', 'house', 'surname', 'name'];
    var arr = ['email', 'phone'];
    var form = $('#form-order').serializeArray();
    var set = true;
    if ($('.chekerAdress[checked="checked"]').val() == 'newAdress') {
        var arr = ['email', 'phone', 'surname', 'name'];
    }
    $.each(form, function (index, item) {
        if (arr.includes(item.name)) {
            if (item.value == '') {
                $('input[name="' + item.name + '"]').addClass('input-invalid');
                set = false;
            }
        }
    });
    if (set) {
        $('#form-order').submit();
    }
})
$(document).on('click', '.close-tmp', function (e) {
    $('.template-alert').css('left', '100%');
})


$(document).on('click', '.addInsurance', function (e) {
    e.preventDefault();
    if ($('.block-belay').length) {
        $('.block-belay').hide();
    }
    $.post("/insurance/add-insurance", function Success(data) {
        if (data) {
            if ($('#pjax-cart-modal').length) {
                $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
            }

            if ($('#pjax-cart').length) {
                $.pjax.reload({ container: '#pjax-cart', replace: true, async: false });
                return false;
            }

            if ($('#pjax-cart-min').length) {
                $.pjax.reload({ container: '#pjax-cart-min', replace: true, async: false });
                return false;
            }
            //$('.block-belay').html('');
            //showAlert("Страховка добавлена в корзину");
            return false;
        }
    });
})
$(document).on('click', '.delete-insurance', function (e) {
    e.preventDefault();
    if ($('.ordering__sidebar-section.block-belay').length) {
        $('.ordering__sidebar-section.block-belay').show();
    }
    var lang = $('#tagLang').val();
    $.post("/insurance/delete-insurance", { lang: lang }, function Success(data) {
        if (data.data) {
            if ($('#pjax-cart').length) {
                $.pjax.reload({ container: '#pjax-cart', replace: true, async: false });
            }
            if ($('#pjax-cart-modal').length) {
                $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
            }
            if ($('#pjax-cart-min').length) {
                $.pjax.reload({ container: '#pjax-cart-min', replace: true, async: false });
                return false;
            }
            showAlert(data.message);
        }
    });
});

$(document).on('click', '#add-coupon', function (e) {
    e.preventDefault();
    var coupon = $('#field-coupon').val();
    if (coupon != '') {
        $.post('/cart/coupon', { coupon: coupon }, function Success(data) {
            if (data) {
                if ($('#pjax-cart-modal').length) {
                    $.pjax.reload({ container: '#pjax-cart-modal', replace: true, async: false });
                }

                if ($('#pjax-cart').length) {
                    $.pjax.reload({ container: '#pjax-cart', replace: true, async: false });
                    return false;
                }

                if ($('#pjax-cart-min').length) {
                    $.pjax.reload({ container: '#pjax-cart-min', replace: true, async: false });
                    return false;
                }
            } else {
                $('#add-coupon').closest('.set_data').addClass('error');
            }
        });
    } else {
        $('#add-coupon').closest('.set_data').addClass('error');
        return false;
    }
});

$(document).on('keyup', '#comment', function (e) {
    $(this).prev('label').css({
        'top': '7px',
        'font-size': '14px'
    })
});





var topCart = 0;
window.addEventListener('message', function (e) {
    if (e.data.topCart && e.data.toFooter) {
        var setTop = e.data.toFooter - e.data.topCart;
        var cartHeight = $('.cart-wraper .cart').height();
        //console.log(cartHeight);
        if (setTop < cartHeight) {
            $('.cart-wraper .cart').animate({
                'top': "auto",
                'bottom': "0"
            }, 10);
        } else {
            if (e.data.topCart > 0) {
                topCart = e.data.topCart;
            } else {
                topCart = 0;
            }
            $('.cart-wraper .cart').animate({
                'top': topCart,
                'bottom': "auto"
            }, 10);
        }
        //console.log(setTop);

    }
})


$(document).on('click', '#interToCart, #interToCart-to', function (e) {
    e.preventDefault();
    parent.postMessage({
        link: $(this).data('link'),
        lang: $(this).data('lang')
    }, '*');
});





if($('.inf i').length){
    if ($('#tagLang').val() != 'ru') {
        if($('#tagLang').val() == 'cs'){
            var aut = 'Autor'
        }else{
            var aut = 'Author'
        }
        var text = $('.inf i').text();
        replaced = text.replace("Автор", aut);
        $('.inf i').text(replaced);
    }   
}

