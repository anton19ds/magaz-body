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

    // $('.recovery_password form').submit(function(e){
    //     e.preventDefault();
    //     $('.popup').hide(0);
    //     $('.success_recovery_password').show(0);
    // });

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
    })

});