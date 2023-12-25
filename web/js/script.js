document.querySelectorAll('.list-option').forEach(b => b.addEventListener('click',
    function (e) {
        this.classList.toggle('rotate');
        sub = this.nextElementSibling;
        sub.classList.toggle('view');
    }
));



$(document).ready(function () {
    $(document).on('click', '.add-to-cart', function (e) {
        e.preventDefault();
        var $yiibtn = $(this);
        $.post("/cart/add-cart", {
            id: $yiibtn.data('id'),
            price: $yiibtn.data('price'),
            symbol: $yiibtn.data('symbol'),
            cyrrency: $yiibtn.data('cyrrency')
        },
            function Success(data) {
                if (data.message) {
                    console.log(data);

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
                } else {
                    $('.tm-data').html(data.info);
                    $('.template-alert').css('left', '0%');

                    setTimeout(function TmpAlertHide() {
                        $('.template-alert').css('left', '-100%');
                    }, 4000);
                }
            })
    });
});


$(document).on('pjax:complete', function (event, data, status, xhr, options) {
    if ($('.cart-modal').length) {
        $('.cart-modal').css('display', 'block');
        $('.cart-modal .cart').animate({
            right: "0%",
        }, 200, function () {
        });
    }
    
    
});







$(document).on('click', '.close-cart', function (e) {
    e.preventDefault();
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
                $.pjax.reload({container: '#pjax-cart', replace: true, async: false });
            }
            if ($('#pjax-cart-modal').length) {
                $.pjax.reload({container: '#pjax-cart-modal', replace: true, async: false });
            }
            if ($('#pjax-cart-min').length) {
                $.pjax.reload({container: '#pjax-cart-min', replace: true, async: false });
                return false;
            }
        }
    })
})

$(document).on('click', '#send-form', function (e) {
    e.preventDefault();
    //var arr = ['email', 'phone', 'country', 'postcode', 'city', 'area', 'street', 'house', 'surname', 'name'];
    var arr = ['email', 'phone', 'surname', 'name'];
    var form = $('#form-order').serializeArray();
    var currensy = $('#currensy').val();
    var set = true;
    $.each(form, function (index, item) {
        if (arr.includes(item.name)) {
            if (item.value == '') {
                $('input[name="' + item.name + '"]').addClass('input-invalid');
                set = false;
            }
        }
    });

    if (set) {
        $.ajax({
            type: "POST",
            url: "/cart/send-order",
            data: form,
            success: function (data) {
                //alert(data);
                if (data) {
                    document.location = "/" + currensy + "/delivery";
                }else{
                    alert('123');
                }
            }
        });
    }
})


$('.set-input-data').keyup(function (e) {
    $(this).removeClass('input-invalid');
});

$(document).on('click', '#send-del', function (e) {
    e.preventDefault();
    var form = $('#form-delivery').serializeArray();
    var currensy = $('#currensy').val();
    $.ajax({
        type: "POST",
        url: "/cart/send-del",
        data: form,
        success: function (data) {
            if (data) {
                document.location = "/" + currensy + "/payment";
            }
        }
    });
})

$(document).on('click', '#send-pay', function (e) {
    e.preventDefault();
    var form = $('#form-payment').serializeArray();
    var currensy = $('#currensy').val();
    $.ajax({
        type: "POST",
        url: "/cart/send-pay",
        data: { form, currensy },
        success: function (data) {
            if (data) {
                //console.log(data);
                document.location = "/" + currensy + "/final-payment";
            } else {
                alert('Укажите тип оплаты');
            }
        }
    });
})



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


