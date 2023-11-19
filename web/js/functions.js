$(document).ready(function (e) {

});

$(function () {
    $('.card')
        .on('mouseenter', function () {
            $(this).find('.card-dropdown').css('display', 'block');
        })
        .on('mouseleave', function () {
            $(this).find('.card-dropdown').css('display', 'none');
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
    // $('.quantity').on('click').
    //     $('.quantity__item')
    //       .on('click', function(e) {
    //         $('.quantity__item').removeClass('active');
    //         $(this).addClas('active');

    //         if($(this).closest('.quantity').hasClass('open')){
    //             $(this).closest('.quantity').removeClass('open');
    //             $('.quantity__item:not(.active)').css('display', 'none');
    //         }else{
    //             $(this).closest('.quantity').addClass('open');
    //             $('.quantity__item').css('display', 'block');

    //         }
    //   });
});
