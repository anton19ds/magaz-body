document.querySelectorAll('.list-option').forEach(b => b.addEventListener('click',
    function (e) {
        this.classList.toggle('rotate');
        sub = this.nextElementSibling;
        sub.classList.toggle('view');
    }
));




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
            console.log(data);
            if (data.message) {
                $('#cart-element-data').html(data.data);
                $('#end-resutl').html(data.summSet + ' ₽');
                $('.cart-modal').css('display', 'block');
                $('.cart-modal .cart').animate({
                    right: "0%",
                }, 200, function () {
                });
            }else{
                alert(data.info);
            }

        })
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
    $.post('/cart/cart-data', function Success(data) {
        $('#cart-element-data').html(data.data);
        $('#end-resutl').html(data.summSet + ' ₽');
        $('.cart-modal .cart').animate({
            right: "0%",
        }, 200, function () {
            $('.cart-modal').css('display', 'block');
        });
    })


});

$(document).on('click', '.delete-elem-in-cart', function (e) {
    var id = $(this).data('id');
    $.post('/cart/remove-tovar-from-cart', { id: id }, function Success(data) {
        if (data) {
            $(".cart-element[data-id='" + id + "']").remove();
            $("#end-resutl").html(data);
        }
    });
})

$(document).on('click', '.plus-tov', function (e) {
    var id = $(this).data('id');
    $.post('/cart/plus-tov', { id: id }, function Success(data) {
        if (data) {
            $(".count[data-id='" + id + "']").html(data.count);
            $(".minus-tov[data-id='" + id + "']").removeClass("grey");
            $("#end-resutl").html(data.summ);
            $(".data-price[data-id='" + id + "']").html(data.setTovar);

        }
    });
});

$(document).on('click', '.minus-tov', function (e) {
    var id = $(this).data('id');
    $.post('/cart/minus-tov', { id: id }, function Success(data) {
        if (data) {
            $(".count[data-id='" + id + "']").html(data.count);
            $("#end-resutl").html(data.summ);
            $(".data-price[data-id='" + id + "']").html(data.setTovar);
        } else {
            $(".minus-tov[data-id='" + id + "']").addClass("grey");
        }
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