$(function () {
    $('#login-btn').click(function (e) {
        e.preventDefault();
        if ($('input[name="LoginForm[username]"]').val() == "") {
            $('.container__authorization form > div').addClass('error_form');
            $('.container__authorization form > div').addClass('name_error');
            return false;
        }

        if ($('input[name="LoginForm[password]"]').val() == "") {
            $('.container__authorization form > div').addClass('error_form');
            $('.container__authorization form > div').addClass('password_error');
            return false;
        }

        var form = $('#login-form').serializeArray();
        $.post('/login/validate', { form: form }, function Success(data) {
            if (!data) {
                $('.container__authorization form > div').addClass('password_error');
                $('.container__authorization form > div').addClass('error_form');
                $('.container__authorization form > div').addClass('name_error');
            } else {
                var lang = $('#lang-data').val();
                var page = $('#login-btn').data('login');
                if (page) {
                    if (page == 'order') {
                        document.location = '/' + lang + '/order'
                    } else {
                        document.location = '/' + page
                    }
                } else {
                    document.location = '/' + lang + '/user'
                }

            }
        });
    });
})

$(function () {
    $('#register-btn').on('click', function (e) {
        e.preventDefault();
        $('.error_message.reg-err').css('display', 'none');
        $('.error_message.inval-err').css('display', 'none');
        if ($('input[name="Register[register]"]').val() == "") {
            $('.container__registration form > div').addClass('name_error');
            return false;
        }
        $.post('/login/register-validate', { email: $('input[name="Register[register]"]').val() }, function Success(data) {
            if (data == '1') {
                $('.container__registration form > div').addClass('error_form');
                $('.error_message.reg-err').css('display', 'flex');
            } else if (data == '3') {
                $('.container__registration form > div').addClass('error_form');
                $('.error_message.inval-err').css('display', 'flex');
            } else {
                $('#refister-form').submit();
            }
        });
    });
});

$(function () {
    $('#btn-recover-pass').on('click', function (e) {
        e.preventDefault();

        if ($('input[name="receiving_name"]').val() != "") {
            var lang = $('#lang-data').val();
            $.post('/login/recover-pass', { lang: lang, email: $('input[name="receiving_name"]').val() }, function Success(data) {
                if (data) {
                    $('.popup').hide(0);
                    $('.success_recovery_password').show(0);
                }
            });
        } else {
            $('input[name="receiving_name"]').addClass('error');
        }

    });
});

$(function () {
    // alert($(this).width());
    $('.pers_acc_menu__header').click(function () {
        if ($('.pers_acc_menu__list').is(':visible')) {
            $('.pers_acc_menu__list').stop().slideUp(300);
            $('.pers_acc_menu_header__button').text('Показать');
        } else {
            $('.pers_acc_menu__list').stop().slideDown(300).css('display', 'flex');
            $('.pers_acc_menu_header__button').text('Скрыть');
        }
    });

    // Наведение на значок в курсе
    $(".icon_stock").on("mouseover", function () {
        $(this).children('span').fadeIn(200);
    }).on('mouseleave', function () {
        $(this).children('span').fadeOut(200);
    });

    // убираем клик по недоступному уроку

    $(".lesson_disabled").click(function (e) {
        e.preventDefault();
    });

    // Открытие/скрытие попап окон

    $('.where_password a').click(function (e) {
        e.preventDefault();
        $('.recovery_password, .all_shadow').fadeIn(200);
    });

    $('.close_popup, .all_shadow').click(function (e) {
        e.preventDefault();
        $('.popup, .all_shadow').fadeOut(200);

    });



    $('.inf_menu__exit > a, .a_exit_menu').click(function (e) {
        e.preventDefault();
        parent.postMessage({
            scroll: "scroll",
        }, '*');
        var top = 350;
        window.addEventListener('message', function (e) {
            top = top + e.data.top;
        });
        $('.popup ').css('top', top + "px");
        $('.exit-lk, .all_shadow').fadeIn(200);
    });


    $('.edit_contact_information').click(function () {
        var data = $(this).data('type');
        $('.edit_contact_information_forms[data-type="' + data + '"]').show(0);
        $('.contacts_information[data-type="' + data + '"]').hide(0);
        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');
    });

    $('.title_edit_contact__forms > p span').click(function () {
        $('.edit_contact_information_forms').hide(0);
        $('.contacts_information').show(0);
        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');
    });

    // открытие формы добавления нового адреса

    $('.add_delivery_address').click(function () {
        $(this).hide(0);
        $('.add_new_address_form').show(0);
        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');


    });

    $('.add_new_address_form .reset_pers_data').click(function () {
        $('.add_new_address_form').hide(0);
        $('.add_new_address_form input, .add_new_address_form select').prev('label').css({
            'top': '15px',
            'font-size': '14px'
        });
        $('.add_delivery_address').show(0);
        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');
    });

    // Поднятие лейблов в полях

    $('.form_pers-data__inputs input, .form_pers-data__inputs select').on('focus keyup', function () {
        $(this).prev('label').css({
            'top': '7px',
            'font-size': '14px'
        });
    });

    $('.form_pers-data__inputs input, .form_pers-data__inputs select').on('focusout keyup', function () {
        if ($.trim($(this).val()) == '' && $(this).is(':focus') === false) {
            $(this).prev('label').css({
                'top': '15px',
                'font-size': '14px'
            });
        }
    });

    // Ошибки в форме добавления адреса

    // $('.add_new_address_form').submit(function(e){
    //     e.preventDefault();
    //     $('.add_new_address_form input, .add_new_address_form select').each(function(){
    //        if ($.trim($(this).val()) === '') {
    //            $(this).css({
    //                'border': '1px solid #D43D47',
    //                'box-shadow': '0 0 0 1px #D43D47'
    //            });
    //            $(this).next('.form_pers-data__inputs-error').show(0);
    //        }
    //     });
    // });

    // Форма редактирования адреса

    // открытие формы и подстановка значений в нее
    $('.update_delivery_address').click(function () {

        // получаем адрес, который редактируем
        let parent_address = $(this).parents('.delivery_address_item');

        // получаем абзацы
        let parent_child = parent_address.children('p');

        // получаем значения адреса
        let id = parent_address.attr('id');
        let name = parent_child.children('.del_address__name').text();
        let surname = parent_child.children('.del_address__surname').text();
        let fname = parent_child.children('.del_address__fname').text();
        let country = parent_child.children('.del_address__country').text();
        let index = parent_child.children('.del_address__index').text();
        let region = parent_child.children('.del_address__region').text();
        let city = parent_child.children('.del_address__city').text();
        let street = parent_child.children('.del_address__street').text();
        let address = parent_child.children('.del_address__address').text();
        let phone = parent_child.children('.del_address__phone').text();
        let email = parent_child.children('.del_address__email').text();

        // подставляем значения в форму
        $('#update_id').val($.trim(id));
        $('#update_country').val($.trim(country));
        $('#update_index_number').val($.trim(index));
        $('#update_region').val($.trim(region));
        $('#update_city').val($.trim(city));
        $('#update_street').val($.trim(street));
        $('#update_address').val($.trim(address));
        $('#update_surname').val($.trim(surname));
        $('#update_name').val($.trim(name));
        $('#update_fname').val($.trim(fname));
        $('#update_email').val($.trim(email));
        $('#update_phone').val($.trim(phone));

        // открываем форму

        if ($(window).width() < 700) {
            parent_address.before($('.update_address_form'));
        }
        $('.update_address_form').show(0);

        $('.delivery_address_item:hidden').show(0); // возвращаем блоки с адресами, если были скрыты
        parent_address.hide(0); // скрываем редактируемый блок адреса
        $('.add_delivery_address').hide(0); // скрываем кнопку добавки нового адреса

        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');
    });

    // скрытие формы

    $('.update_address_form .reset_pers_data').click(function () {
        $('.update_address_form').hide(0); // скрываем форму
        $('.delivery_address_item:hidden').show(0); // возвращаем все блоки с адресами
        $('.add_delivery_address').show(0); // возвращаем кнопку добавки адресов
        var h2 = document.getElementById('pageSetBody').scrollHeight;
        parent.postMessage({
            heUserBonuses: h2,
        }, '*');
    });

    // попап удаления адреса

    $('.delete_delivery_address').click(function () {
        $('.all_shadow, .delete_address_popup').fadeIn(200);
        $('.links_exit a').attr('data-id', $(this).data('id'));
    });

    $(document).on('click', '#logoutUser', function (e) {
        e.preventDefault();
        var lang = $('#tagLang').val();
        $.post('/logout', {}, function (data) {
            if (data) {
                parent.postMessage({
                    linkData: "/" + lang + "/shop",
                    top: true
                }, '*');
            }
        })
    });
    $('#removeAdress').on('click', function (e) {
        e.preventDefault();
        $.post('/remove-user-adress', { id: $(this).data('id') }, function Success(data) {
            if (data) {
                document.location = document.location;
            }
        });
    })

    // Отправка и проверка на ошибки в форме редактирования адреса

    // $('.update_address_form').submit(function(e){
    //     e.preventDefault();
    //     $('.update_address_form input, .update_address_form select').each(function(){
    //         if ($.trim($(this).val()) === '') {
    //             $(this).css({
    //                 'border': '1px solid #D43D47',
    //                 'box-shadow': '0 0 0 1px #D43D47'
    //             });
    //             $(this).next('.form_pers-data__inputs-error').show(0);
    //         }
    //     });
    // });

    // Если ошибка исправлена

    $('.add_new_address_form input, .add_new_address_form select, .update_address_form input, .update_address_form select').on('change keyup', function () {
        if ($.trim($(this).val()) !== '') {
            $(this).css({
                'border': '1px solid #D9D9D9',
                'box-shadow': 'none'
            });
            $(this).next('.form_pers-data__inputs-error').hide(0);
        }
    });
    // КОД ДЛЯ ДЕМОНСТРАЦИИ ОШИБКИ СМЕНЫ ПАРОЛЯ (УДАЛИТЬ)
    // $('.edit_contact__forms').submit(function(e){
    //    e.preventDefault();
    //    $('.now_pass, .confirm_pass').addClass('error_personal_info_form');
    // });
    // КОНЕЦ
});
// РАЗДЕЛ ПРОМОКОДОВ
renameTablePromocode();
$(window).resize(function () {
    renameTablePromocode();
});
function renameTablePromocode() {
    if ($(window).width() < 1101) {
        // $('.table_promocodes__head .sale_client .promocode_line__title').text('% клиенту');
        // $('.table_promocodes__head .rewards_buy .promocode_line__title').text('% мне');
        // $('.table_promocodes__head .summ_percent .promocode_line__title').text('Суммарно');
    } else {
        // $('.table_promocodes__head .sale_client .promocode_line__title').text('Скидка клиенту (по промокоду)');
        // $('.table_promocodes__head .rewards_buy .promocode_line__title').text('Вознаграждение за покупки привлеченных вами клиентов');
        // $('.table_promocodes__head .summ_percent .promocode_line__title').text('Сумма процентов');
    }
}

$('.benefit_link').click(function () {
    $('.all_shadow, .benefit_popup').fadeIn(200);
});

$('#send-new-req-promo').on('click', function (e) {
    e.preventDefault();
    if ($('#why_benefit').val() != '') {
        var array = $('#why_benefit_form').serializeArray();
        var lang = $('#tagLang').val();
        $.post('/send-form-benefit', { data: array, lang: lang }, function Success(data) {
            if (data) {
                //console.log(data);
                $('#why_benefit').val('');
                $('.benefit_popup').hide(0);
                $('.success_benefit').show(0);
            }
        });
    } else {
        $('#why_benefit').css('border', '1px solid red');
    }
});
// СОЗДАНИЕ НОВОГО ПРОМОКОДА
$('.button_add_promocode span').click(function () {
    $('.all_shadow, .add_promocode_popup').fadeIn(200);
});

// Инпуты названия и ссылки промокодов

$('#link_new_promocode').on('keyup', function (e) {
    $(this).css('border', '1px solid #C1C1C1');

})
$('.nick_new_promocode__inp input').on('keyup', function () {
    $(this).css('border', '1px solid #C1C1C1');
    let nick = $(this).val();
    $('.nick_promocode_notification').hide(0);
    $('.nick_new_promocode__inp').removeClass('nick_new_promocode__error');
    $('.result_nick_promocode').text(nick);
});

$('.nick_new_promocode__inp input').on('change', function () {
    let nick = $(this).val();
    $('.nick_open').hide(0);
    $('.nick_occupied').hide(0);
    $('.nick_disable').hide(0);
    if (!/^([a-zA-Z0-9 /]+)$/.test(nick) || nick.length > 10) {
        $('.nick_new_promocode__inp').addClass('nick_new_promocode__error');
        $('.nick_disable').fadeIn(200);
    } else {
        $.post('/api/check-promo', { nick: nick }, function Success(data) {
            $('.nick_open').hide(0);
            $('.nick_occupied').hide(0);
            if (data) {
                $('.nick_open').fadeIn(200);
                $('.nick_new_promocode__inp').removeClass('nick_new_promocode__error');
            } else {
                $('.nick_new_promocode__inp').addClass('nick_new_promocode__error');
                $('.nick_occupied').fadeIn(200);
            }
        });
    }
});


// ввод процентов

$('.promocode_percents__line input[type="number"]').on('keyup', function () {
    let number = $(this).val();
    if (number < 0 || (number.length > 1 && number.charAt(0) == 0)) {
        $(this).val(0);
    }
    if ($(this).val() > 99) {
        $(this).val(99);
    }
});




function loadOnCase() {
    $('.type_new_group input[type="number"]').each(function () {
        let summ = 0;
        let group = $(this).attr('group_percent');
        $("input[group_percent=" + group + "]").each(function () {
            summ += Number($(this).val());
        });
        var parent = $(this).closest('.promocode_line');
        if (Number(summ) != Number($(this).attr('data-summ'))) {
            parent.addClass('percents_line_error');
        } else {
            //alert('2');
            //percent_error percent_error_big
        }
    });
}
loadOnCase();


$('.promocode_percents__line input[type="number"]').on('change', function () {
    let summ = 0;
    let group = $(this).attr('group_percent');
    let parent = $(this).closest('.promocode_percents__line');
    parent.removeClass('percents_line_error');
    parent.children('.percent_error').hide(0);
    $(parent.find("input[group_percent=" + group + "]")).each(function () {
        summ += Number($(this).val());
    });

    if (Number(summ) == Number($(this).attr('data-summ'))) {
        parent.addClass('percents_line_true');
    }
    if (Number(summ) != Number($(this).attr('data-summ'))) {
        parent.addClass('percents_line_error');
    } else {

        parent.removeClass('percents_line_error');
    }

    if (Number(summ) < Number($(this).attr('data-summ'))) {
        parent.children('.percent_error_small').show(0);
    }

    if (Number(summ) > Number($(this).attr('data-summ'))) {
        parent.children('.percent_error_big').show(0);
    }
    if ($(this).val().length == 0) {
        $(this).val(0);
    }
});

$('.submit_add_promocode input').on('click', function (e) {
    e.preventDefault();
    var errorProcent = true;
    $('#form_add_promocode .promocode_percents__line').removeClass('percents_line_error');
    $('.promocode_percents__line input[type="number"]').each(function () {
        let summ = 0;
        let group = $(this).attr('group_percent');
        $("#form_add_promocode input[group_percent=" + group + "]").each(function () {
            summ += Number($(this).val());
        });
        if (Number(summ) != Number($(this).attr('data-summ'))) {
            $(this).closest('.promocode_percents__line').addClass('percents_line_error');
            errorProcent = false;
        }
    });
    var data = $('#form_add_promocode').serializeArray();
    var set = true;
    $.each(data, function (index, prop) {
        if (prop.value == '') {
            console.log(prop.value);
            if ($(`input[name="${prop.name}"]`).length) {
                $(`input[name="${prop.name}"]`).css("border", "1px solid #D43C46");
                console.log($(`input[name="${prop.name}"]`));
                set = false;
                console.log(set);
            }
        }
    });
    if ($('#form_add_promocode').find('.percents_line_error').length || $('.nick_new_promocode__error').length) {
        set = false;
    }

    if (errorProcent && set) {
        $('#form_add_promocode').submit();
    }
});


// ИЗМЕНИЛИСЬ ПРОЦЕНТЫ В ТАБЛИЦЕ - ВВОД ПРОЦЕНТОВ

$('.new_group input[type="number"]').on('change', function () {
    let summ = 0;
    let group = $(this).attr('group_percent');
    let parent = $(this).parent('p').parent('.promocode_line');
    parent.removeClass('percents_line_error');
    parent.children('.percent_error').hide(0);

    parent.find("input[group_percent=" + group + "]").each(function () {
        summ += Number($(this).val());
    });
    if (Number(summ) == Number($(this).attr('data-summ'))) {
        parent.addClass('percents_line_true');
    }
    if (Number(summ) != Number($(this).attr('data-summ'))) {
        parent.addClass('percents_line_error');
    }
    if (Number(summ) < Number($(this).attr('data-summ'))) {
        parent.children('.percent_error_small').show(0);

    }
    if (Number(summ) > Number($(this).attr('data-summ'))) {
        parent.children('.percent_error_big').show(0);
    }

    if ($(this).val().length == 0) {
        $(this).val(0);
    }
});

$('.sends-btn').on('click', function (e) {
    e.preventDefault();
    var form = $(this).closest('form');

    if (!form.find('.percents_line_error').length) {
        form.submit();
    }
})
// ОТЧЕТЫ
// календарь
$('.filter_date > input').click(function () {
    $(this).prev('.calendar_container').show(0);
});


$(document).mouseup(function (e) {
    var div = $(".calendar_container");
    if (!div.is(e.target)
        && div.has(e.target).length === 0) {
        div.hide();
    }
});

var date = new Date();
var year = date.getFullYear();
var month = date.getMonth();
var nowday = date.getDate();
var m;
var count_days;
var month_calendar;
var now_month;
var date_day;

var monday = [];
var tuesday = [];
var wednesday = [];
var thursday = [];
var friday = [];
var saturday = [];
var sunday = [];

function nowMonth(x) {
    switch (x) {
        case 0:
            m = 'Январь';
            break;
        case 1:
            m = 'Февраль';
            break;
        case 2:
            m = 'Март';
            break;
        case 3:
            m = 'Апрель';
            break;
        case 4:
            m = 'Май';
            break;
        case 5:
            m = 'Июнь';
            break;
        case 6:
            m = 'Июль';
            break;
        case 7:
            m = 'Август';
            break;
        case 8:
            m = 'Сентябрь';
            break;
        case 9:
            m = 'Октябрь';
            break;
        case 10:
            m = 'Ноябрь';
            break;
        case 11:
            m = 'Декабрь';
            break;
    }
    return m;
}

function howMuchDays(year, month) {
    var date1 = new Date(year, month - 1, 1);
    var date2 = new Date(year, month, 1);
    return Math.round((date2 - date1) / 1000 / 3600 / 24);
}

function howWorkDays(year1, month1, day1, year2, month2, day2) {
    var work_date1 = new Date(year1, month1, day1);
    var work_date2 = new Date(year2, month2, day2);
    return Math.round((work_date2 - work_date1) / 1000 / 3600 / 24);
}

function contentCalendar() {
    for (var i = 0; i < sunday.length; i++) {
        $('.sunday').append('<span class="yes_check_date">' + sunday[i] + '</span>');
    }
    for (var i = 0; i < monday.length; i++) {
        $('.monday').append('<span class="yes_check_date">' + monday[i] + '</span>');
    }
    for (var i = 0; i < tuesday.length; i++) {
        $('.tuesday').append('<span class="yes_check_date">' + tuesday[i] + '</span>');
    }
    for (var i = 0; i < wednesday.length; i++) {
        $('.wednesday').append('<span class="yes_check_date">' + wednesday[i] + '</span>');
    }
    for (var i = 0; i < thursday.length; i++) {
        $('.thursday').append('<span class="yes_check_date">' + thursday[i] + '</span>');
    }
    for (var i = 0; i < friday.length; i++) {
        $('.friday').append('<span class="yes_check_date">' + friday[i] + '</span>');
    }
    for (var i = 0; i < saturday.length; i++) {
        $('.saturday').append('<span class="yes_check_date">' + saturday[i] + '</span>');
    }
}

count_days = howMuchDays(year, month + 1);
for (var i = 1; i <= count_days; i++) {
    date_day = new Date(year, month, i);
    switch (date_day.getDay()) {
        case 0:
            sunday.push(i);
            if (i == 1) {
                $('.sunday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
        case 1:
            monday.push(i);
            break;
        case 2:
            tuesday.push(i);
            if (i == 1) {
                $('.tuesday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
        case 3:
            wednesday.push(i);
            if (i == 1) {
                $('.wednesday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
        case 4:
            thursday.push(i);
            if (i == 1) {
                $('.thursday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
        case 5:
            friday.push(i);
            if (i == 1) {
                $('.friday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
        case 6:
            saturday.push(i);
            if (i == 1) {
                $('.saturday').prevAll('.line_calendar').append('<span></span>');
            }
            break;
    }
}

now_month = nowMonth(month);
$('.now_month').text(now_month + ' ' + year);
contentCalendar();

$('.line_calendar span').each(function () {
    if ($(this).html() == '') {
        $(this).css('background', 'none');
    }
});

$('.next_month').click(function () {
    if (month == 11) {
        month = 0;
        year++;
    }
    else {
        month++;
    }
    now_month = nowMonth(month);
    $('.now_month').text(now_month + ' ' + year);

    $('.line_calendar span').remove();
    monday = [];
    tuesday = [];
    wednesday = [];
    thursday = [];
    friday = [];
    saturday = [];
    sunday = [];

    count_days = howMuchDays(year, month + 1);
    for (var i = 1; i <= count_days; i++) {
        date_day = new Date(year, month, i);
        switch (date_day.getDay()) {
            case 0:
                sunday.push(i);
                if (i == 1) {
                    $('.sunday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 1:
                monday.push(i);
                break;
            case 2:
                tuesday.push(i);
                if (i == 1) {
                    $('.tuesday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 3:
                wednesday.push(i);
                if (i == 1) {
                    $('.wednesday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 4:
                thursday.push(i);
                if (i == 1) {
                    $('.thursday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 5:
                friday.push(i);
                if (i == 1) {
                    $('.friday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 6:
                saturday.push(i);
                if (i == 1) {
                    $('.saturday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
        }
    }
    contentCalendar();
    $('.yes_check_date').click(function () {
        $('.line_calendar span').removeClass('active_date');
        $(this).addClass('active_date');

        let parent = $(this).parents('.calendar_container');
        let text_month = (month + 1).toString()
        let text_day = $(this).text()

        if (text_month.length === 1) {
            text_month = '0' + text_month;
        }
        if (text_day.length === 1) {
            text_day = '0' + text_day;
        }
        addValInputCal(parent, text_day + '/' + text_month + '/' + year)
    });

});

$('.prev_month').click(function () {
    if (month == (date.getMonth() + 1) && year == date.getFullYear()) {
        $(this).css({
            'cursor': 'default',
            'opacity': 0
        });
    }
    if (month == 0) {
        month = 11;
        year--;
    }
    else {
        month--;
    }
    now_month = nowMonth(month);
    $('.now_month').text(now_month + ' ' + year);

    $('.line_calendar span').remove();
    monday = [];
    tuesday = [];
    wednesday = [];
    thursday = [];
    friday = [];
    saturday = [];
    sunday = [];

    count_days = howMuchDays(year, month + 1);
    for (var i = 1; i <= count_days; i++) {
        date_day = new Date(year, month, i);
        switch (date_day.getDay()) {
            case 0:
                sunday.push(i);
                if (i == 1) {
                    $('.sunday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 1:
                monday.push(i);
                break;
            case 2:
                tuesday.push(i);
                if (i == 1) {
                    $('.tuesday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 3:
                wednesday.push(i);
                if (i == 1) {
                    $('.wednesday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 4:
                thursday.push(i);
                if (i == 1) {
                    $('.thursday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 5:
                friday.push(i);
                if (i == 1) {
                    $('.friday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
            case 6:
                saturday.push(i);
                if (i == 1) {
                    $('.saturday').prevAll('.line_calendar').append('<span></span>');
                }
                break;
        }
    }
    $('.line_calendar span').each(function () {
        if ($(this).html() == '') {
            $(this).css('background', 'none');
        }
    });
    contentCalendar();
    $('.yes_check_date').click(function () {
        $('.line_calendar span').removeClass('active_date');
        $(this).addClass('active_date');

        let parent = $(this).parents('.calendar_container');
        let text_month = (month + 1).toString()
        let text_day = $(this).text()

        if (text_month.length === 1) {
            text_month = '0' + text_month;
        }
        if (text_day.length === 1) {
            text_day = '0' + text_day;
        }
        addValInputCal(parent, text_day + '/' + text_month + '/' + year)
    });
});

$('.yes_check_date').click(function () {
    $('.line_calendar span').removeClass('active_date');
    $(this).addClass('active_date');

    let parent = $(this).parents('.calendar_container');
    let text_month = (month + 1).toString()
    let text_day = $(this).text()

    if (text_month.length === 1) {
        text_month = '0' + text_month;
    }
    if (text_day.length === 1) {
        text_day = '0' + text_day;
    }
    var data = text_day + '/' + text_month + '/' + year;
    addValInputCal(parent, data);
});

function addValInputCal(parent, value) {
    parent.next('input').val(value);
    var type = parent.data('val');
    parent.hide(0);
    var params = window
        .location
        .search
        .replace('?', '')
        .split('&')
        .reduce(
            function (p, e) {
                var a = e.split('=');
                p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {}
        );
    if (params.start) {
        console.log(params.start);
    }
    if (params.finish) {
        console.log(params.start);
    }
}

$('.filter_balance_button input').click(function (e) {
    e.preventDefault();
    $('.output_balance_popup, .all_shadow').fadeIn(200);
});


$('#form-send-bal').on('click', function (e) {
    e.preventDefault();
    var summ = $('#summ_output').data('summ');
    var summUser = $('#summ_output').data('user');
    if (Number($('#summ_output').val()) < summ) {
        $('.error-user-message.min').show(0);
        $('#summ_output').parent('.output_balance_form__inp').addClass('error_inp');
    }
    else if (Number($('#summ_output').val()) > summUser) {
        $('.error-user-message.max').show(0);
        $('#summ_output').parent('.output_balance_form__inp').addClass('error_inp');
    } else if ($('#data_output').val() == '') {
        $('#data_output').addClass('error');
    } else if ($('#link_output').val() == '') {
        $('#link_output').addClass('error');
    }
    else {
        $('.output_balance_form').submit();
        $('.output_balance_popup').hide(0);
        $('.success_benefit').show(0);
    }
});

$('#summ_output').keyup(function (e) {
    $('.error-user-message.max').hide(0);
    $('.error-user-message.min').hide(0);
    $('#summ_output').parent('.output_balance_form__inp').removeClass('error_inp');
});

$(document).on('click', '.copy_icon', function () {
    let copy_text = $(this).data('link');
    let copy_name = $(this).data('name');
    $('.' + copy_name).css('display', 'flex');
    setTimeout(() => $('.yes_copied.' + copy_name).hide(), 1000);
    parent.postMessage({
        copyText: 'copy',
        text: copy_text
    }, '*');

});

// РАБОТА С БОНУСАМИ

// Связь клика по заданию и выбора в списке

$('.exercise__item').click(function () {
    if ($(this).hasClass('exercise_done') || $(this).hasClass('exercise_view')) return; // выходим, если задание выполнено

    changeColorBonusSelect();

    let id = $(this).attr('id'); // получаем id бонуса по которому кликнули
    $('#answer_bonus_exercise select option').removeAttr('selected'); // убираем выделение всех элементов списка
    $('.exercise__item').removeClass('exercise__focus'); // удаляем у всех бонусов фокус

    $('#answer_bonus_exercise select option[value=' + id + ']').attr('selected', 'selected'); // выбираем элемент в списке, по которому кликнули
    $('#answer_bonus_exercise select').val(id);
    $(this).addClass('exercise__focus'); // добавляем фокус для задания, по которому кликнули
});

$('#answer_bonus_exercise select').change(function () {
    changeColorBonusSelect();

    $('.exercise__item').removeClass('exercise__focus');
    let id = $(this).val();
    if ($('.exercise__item#' + id).hasClass('exercise_done')) return; // выходим, если задание выполнено

    $('.exercise__item#' + id).addClass('exercise__focus');
});

// меняем цвет букв селекта на черный
function changeColorBonusSelect() {
    $('#answer_bonus_exercise select').css({
        'color': '#000',
        'box-shadow': '0 0 0 1px #00A6CA',
        'border': '1px solid #00A6CA'
    });
}

// стили поля ввода комментария

$("#answer_bonus_exercise input[type='text'],#answer_bonus_exercise textarea").on('keyup', function () {
    if ($(this).val().length > 0) {
        $(this).css({
            'box-shadow': '0 0 0 1px #00A6CA',
            'border': '1px solid #00A6CA'
        });
    } else {
        $(this).css({
            'box-shadow': 'none',
            'border': '1px solid #C0C0C0'
        });
    }
});

// Добавляем и удаляем имена загруженных файлов

$('#answer_files_exercise').change(function () {

    for (var i = 0; i < $(this)[0].files.length; i++) {
        let item = $(this)[0].files.item(i).name;
        $('.list_download_files').append('<li>' + item + '<span class="delete_files" data-id="' + i + '"></span></li>');
        if (i > 3 || $(this)[0].files.item(i).size > 6250000) {
            $('.error_size_file').addClass('error_photo_files');
            $(".photo_files").addClass('error_photo_files');
            $(".info-size-file").addClass('error_photo_files');
            return;
        }
    }

    if ($('#answer_files_exercise')[0].files.length > 0) {
        $('.photo_files').removeClass('error_photo_files');
        $(".info-size-file").removeClass('error_photo_files');
        $('.error_empty_file').hide(0);
    }
    var h2 = document.getElementById('bonuses').scrollHeight;
    parent.postMessage({
        heUserBonuses: h2,
    }, '*');
});

$(document).on('click', '.delete_files', function () {
    $('.photo_files').removeClass('error_photo_files');
    $(".info-size-file").removeClass('error_photo_files');
    $('.error_empty_file').hide(0);

    var fileData = $('input[type=file]')[0].files;
    var regh;
    var dataId = $(this).attr('data-id');
    console.log($(this).attr('data-id'));
    console.log(fileData);
    var removeKey = {};
    var dt = new DataTransfer();
    $.each(fileData, function (key, value) {
        if (dataId != key) {
            dt.items.add(new File([value], value.name, { type: 'text/plain' }));
        }
    });
    var file_list = dt.files;
    $('.list_download_files').html('');
    if (file_list.length > 3) {
        $(".info-size-file").addClass('error_photo_files');
    }
    for (var i = 0; i < file_list.length; i++) {
        let item = file_list.item(i).name;
        $('.list_download_files').append('<li>' + item + '<span class="delete_files" data-id="' + i + '"></span></li>');
        if (file_list.item(i).size > 625000) {
            $(".info-size-file").addClass('error_photo_files');
        }
    }
    document.querySelector('input[type="file"]').files = file_list;
    var h2 = document.getElementById('bonuses').scrollHeight;
    parent.postMessage({
        heUserBonuses: h2,
    }, '*');
});

// Отправка формы фотоотчета

$(document).on('click', '#send-this-data', function (e) {
    e.preventDefault();
    for (var i = 0; i < $('#answer_files_exercise')[0].files.length; i++) {
        if (i > 3 || $('#answer_files_exercise')[0].files.item(i).size > 625000) {
            $('.error_size_file').addClass('error_photo_files');
            $(".photo_files").addClass('error_photo_files');
            $(".info-size-file").addClass('error_photo_files');
            return false;
        }
    }

    if ($('#answer_files_exercise')[0].files.length == 0) {
        $('.photo_files').addClass('error_photo_files');
        $('.error_empty_file').show(0);
        return false;
    } else {
        var formData = new FormData();
        const fileData = $('input[type=file]')[0].files;
        $.each(fileData, function (key, value) {
            formData.append(key, value);
        });
        formData.append('type_exercise', $('#type_exercise').val());
        formData.append('comment_exercise', $('#comment_exercise').val());
        formData.append('lang', $('#tagLang').val());

        $.ajax({
            url: '/form-bonus',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (respond, status, jqXHR) {
                if (respond.message == 'ok') {
                    document.location = document.location;
                }
                if (typeof respond.error === 'undefined') {
                    console.log(respond);
                }
                else {
                    console.log('ОШИБКА: ' + respond.data);
                }
            },
            error: function (jqXHR, status, errorThrown) {
                console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
            }
        });
    }
});

// открытие формы и подстановка значений в нее
$('.ordering__main .delivery_address_item').click(function () {
    $('.delivery_addresses__list label').removeClass('active');
    $(this).addClass('active');

    // получаем абзацы
    let parent_child = $(this).children('.delivery_address_item__info').children('p');

    // получаем значения адреса
    let name = parent_child.children('.del_address__name').text();
    let surname = parent_child.children('.del_address__surname').text();
    let fname = parent_child.children('.del_address__fname').text();
    let country = parent_child.children('.del_address__country').text();
    let index = parent_child.children('.del_address__index').text();
    let region = parent_child.children('.del_address__region').text();
    let city = parent_child.children('.del_address__city').text();
    let street = parent_child.children('.del_address__street').text();
    let address = parent_child.children('.del_address__address').text();

    // подставляем значения в форму
    $('#country').val(country.trim());
    $('#index_number').val(index.trim());
    $('#region').val(region.trim());
    $('#city').val(city.trim());
    $('#street').val(street.trim());
    $('#address').val(address.trim());
    $('#surname').val(surname.trim());
    $('#name').val(name.trim());
    $('#fname').val(fname.trim());

    $('.contact_info__section input').each(function (e) {
        $(this).attr('readonly', 'true');
    })

    $('.form_pers-data__inputs input, .form_pers-data__inputs select, .form_pers-data__inputs textarea').each(function () {
        if ($.trim($(this).val()) == '' && $(this).is(':focus') === false) {
            $(this).prev('label').css({
                'top': '15px',
                'font-size': '16px'
            });
        } else {
            $(this).prev('label').css({
                'top': '7px',
                'font-size': '14px'
            });
        }
    });
});

$('.ordering__main .new_delivery_address').click(function () {
    $('.form_pers-data__inputs input, .form_pers-data__inputs select, .form_pers-data__inputs textarea').val('');
    $('.delivery_addresses__list label').removeClass('active');
    $(this).addClass('active');

    $('.contact_info__section input').each(function (e) {
        $(this).removeAttr('readonly');
    })
    let navig_top = $('.form_pers-data__inputs').offset().top;

    $("html,body").stop().animate({
        scrollTop: navig_top
    }, 1500);
})

$('#send_feedback').on('click', function (e) {
    e.preventDefault();
    $('#feedback_message').removeClass('error');
    $('#feedback_theme').removeClass('error');
    if ($('#feedback_theme').val() == '') {
        $('#feedback_theme').addClass('error');
        return false;
    }
    if ($('#feedback_message').val() == '') {
        $('#feedback_message').addClass('error');
        return false;
    }
    $('#feedback_form').submit();
})

$('#submitUserData').on('click', function (e) {
    e.preventDefault();
    var step = true;
    $('#userDataForm input').each(function (e) {
        if ($(this).val() == '') {
            $(this).addClass('error');
            $(this).next('.form_pers-data__inputs-error').css('display', 'block');
            step = false;
        }
    });
    if (step) {
        $('#userDataForm').submit();
    }
})


$('#setNewPassword').on('click', function (e) {
    e.preventDefault();
    var update = true;
    if ($('#now_pass').val() == '') {
        $('#now_pass').addClass('error');
        $('#now_pass').next('.error_message').css('display', 'block');
        update = false;
    }
    if ($('#new_pass').val() == '') {
        $('#new_pass').addClass('error');
        update = false;
    }
    if ($('#confirm_new_pass').val() == '') {
        $('#confirm_new_pass').addClass('error');
        update = false;
    }

    if ($('#confirm_new_pass').val() != $('#new_pass').val()) {
        $('#confirm_new_pass').addClass('error');
        $('#new_pass').addClass('error');
        $('#confirm_new_pass').next('.error_message').css('display', 'block');
        update = false;
    }

    $.post('/form-password', { "pass": $('#now_pass').val() }, function Success(data) {
        if (data) {
            if (update) {
                $('#update-password').submit();
            } else {
                return false;
            }
        } else {
            $('#now_pass').addClass('error');
            $('#now_pass').next('.error_message').css('display', 'block');
        }
    });
})

$('.go_cancel_order').on('click', function (e) {
    e.preventDefault();
    $('.cancel_order_popup, .all_shadow').fadeIn(200);
});

$('.sert-close').on('click', function (e) {
    e.preventDefault();
    $.post('/close-order', { 'id': $(this).data('id') }, function Success(data) {
        if (data) {
            document.location = document.location;
        }
    });
});


$('.delete_promocode_link').on('click', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.post('/delete-promo', { "id": id }, function Success(data) {
        if (data) {
            document.location = document.location;
        }
    });
})


// $('#summ_output').on('input', function() {
//     $(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
// });


if ($('#summ_output').length) {
    document.getElementById('summ_output').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D+/g, "");  // Прощайте, лишние символы!
    });
    document.getElementById('summ_output').addEventListener('keypress', function (e) {
        if (e.key === '.' && this.value.includes('.')) {
            e.preventDefault();  // Не допускаем повторения точек!
        } else if (!/[0-9]/.test(e.key)) {
            e.preventDefault();  // Что за незаконный вторженец? Не цифра!
        }
    });
}
$(document).on('click', '.gelt-det', function (e) {
    $('.newuser_popup').css('display', 'none');
    $('.asdf').css('display', 'none');
});

if ($('.seconds-block').length) {
    var _Seconds = $('.seconds-block').text(),
        int;
    int = setInterval(function () {
        if (_Seconds > 0) {
            _Seconds--;
            $('.seconds-block').text(_Seconds);
        } else {
            clearInterval(int);

            if($('.result_pay_info__email').length){
                var location = $('.result_pay_info__email').attr('href');
                window.open(location, '_blank')
            }
            if($('.result_pay_info__yandex').length){
                var location = $('.result_pay_info__yandex').attr('href');
                window.open(location, '_blank')
            }
            
        }
    }, 1000);
}


//result_pay_info__email
//

window.addEventListener('message', function (e) {
    if (e.data.linkSetPath && e.data.linkProduct && e.data.lang) {
        var link = e.data.linkSetPath;
        var lang = e.data.lang;
        $.post('/ajax/link-new', { link: link, lang: lang }, function Success(data) {
            if (data) {
                parent.postMessage({
                    newLink: data,
                }, '*');
            }

        });
    }
})


$(document).on('click', 'a[data-set-link]', function (e) {
    if ($(this).data('set-link') != '' && $(this).data('set-link').length) {
        e.preventDefault();
        var data = $(this).data('set-link');
        parent.postMessage({
            linkData: data,
        }, '*');
    }
})


$('#promocodeNameFilter').on('change', function(e){
    $('#form-filter').submit();
})
$(document).on('click', '.yes_check_date', function(e){
    $('#form-filter').submit();
})