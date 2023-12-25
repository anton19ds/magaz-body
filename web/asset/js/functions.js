$(function(){
$('#login-btn').click(function(e){
    e.preventDefault();
    if($('input[name="LoginForm[username]"]').val() == ""){
        $('.container__authorization form > div').addClass('error_form');
        $('.container__authorization form > div').addClass('name_error');
        return false;
    }

    if($('input[name="LoginForm[password]"]').val() == ""){
        $('.container__authorization form > div').addClass('error_form');
        $('.container__authorization form > div').addClass('password_error');
        return false;
    }

    $('#login-form').submit();
});
})


$(function(){
    // alert($(this).width());
    $('.pers_acc_menu__header').click(function(){
        if ($('.pers_acc_menu__list').is(':visible')) {
            $('.pers_acc_menu__list').stop().slideUp(300);
            $('.pers_acc_menu_header__button').text('Показать');
        } else {
            $('.pers_acc_menu__list').stop().slideDown(300).css('display', 'flex');
            $('.pers_acc_menu_header__button').text('Скрыть');
        }
    });

    // Наведение на значок в курсе
    $( ".icon_stock" ).on( "mouseover", function() {
        $(this).children('span').fadeIn(200);
    }).on('mouseleave', function(){
        $(this).children('span').fadeOut(200);
    });

    // убираем клик по недоступному уроку

    $(".lesson_disabled").click(function(e){
        e.preventDefault();
    });

    // Открытие/скрытие попап окон

    $('.where_password a').click(function(e){
       e.preventDefault();
        $('.recovery_password, .all_shadow').fadeIn(200);
    });

    $('.close_popup, .all_shadow').click(function(e){
        e.preventDefault();
        $('.popup, .all_shadow').fadeOut(200);
    });




    // ДЛЯ ДЕМОНСТРАЦИИ: (УДАЛИТЬ КОД ВНИЗУ)

    $('.recovery_password form').submit(function(e){
        e.preventDefault();
        $('.popup').hide(0);
        $('.success_recovery_password').show(0);
    });

    // $('.container__authorization').submit(function(e){
    //    e.preventDefault();
    //    $('.container__authorization form > div').addClass('error_form');
    // });
    // $('.container__registration').submit(function(e){
    //     e.preventDefault();
    //     $('.container__registration form > div').addClass('error_form');
    // });

    // КОНЕЦ ТОГО, ЧТО НАДО УДАЛИТЬ

    // ПОПАП ВЫХОДА ИЗ ЛК

    $('.inf_menu__exit > a, .a_exit_menu').click(function(e){
        e.preventDefault();
        $('.exit-lk, .all_shadow').fadeIn(200);
    });

    // ФОРМЫ НА СТРАНИЦЕ ЛИЧНЫХ ДАННЫХ

    // открытие/скрытие формы редактирования данных

    $('.edit_contact_information').click(function(){
        var data = $(this).data('type');
       $('.edit_contact_information_forms[data-type="'+data+'"]').show(0);
       $('.contacts_information[data-type="'+data+'"]').hide(0);
    });

    $('.title_edit_contact__forms > p span').click(function(){
        $('.edit_contact_information_forms').hide(0);
        $('.contacts_information').show(0);
    });

    // открытие формы добавления нового адреса

    $('.add_delivery_address').click(function(){
        $(this).hide(0);
        $('.add_new_address_form').show(0);
    });

    $('.add_new_address_form .reset_pers_data').click(function(){
       $('.add_new_address_form').hide(0);
       $('.add_new_address_form input, .add_new_address_form select').prev('label').css({
           'top':'15px',
           'font-size': '14px'
       });
       $('.add_delivery_address').show(0);
    });

    // Поднятие лейблов в полях

    $('.form_pers-data__inputs input, .form_pers-data__inputs select').on('focus keyup',function(){
        $(this).prev('label').css({
            'top':'7px',
            'font-size': '14px'
        });
    });

    $('.form_pers-data__inputs input, .form_pers-data__inputs select').on('focusout keyup', function(){
        if($.trim($(this).val()) == '' && $(this).is(':focus') === false){
            $(this).prev('label').css({
                'top':'15px',
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
    $('.update_delivery_address').click(function(){

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

    });

    // скрытие формы

    $('.update_address_form .reset_pers_data').click(function(){
        $('.update_address_form').hide(0); // скрываем форму
        $('.delivery_address_item:hidden').show(0); // возвращаем все блоки с адресами
        $('.add_delivery_address').show(0); // возвращаем кнопку добавки адресов
    });

    // попап удаления адреса

    $('.delete_delivery_address').click(function(){
       $('.all_shadow, .delete_address_popup').fadeIn(200);
    });

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

    $('.add_new_address_form input, .add_new_address_form select, .update_address_form input, .update_address_form select').on('change keyup', function(){
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