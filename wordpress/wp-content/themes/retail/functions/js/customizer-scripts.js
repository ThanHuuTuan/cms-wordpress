jQuery(document).ready(function($) {
    "use strict";

    //Icons Dropdown
    $('body').on('click', '.icon-list li', function(){
        var icon_class = $(this).find('i').attr('class');
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.icon-list').prev('.selected-icon').children('i').attr('class','').addClass(icon_class);
        $(this).parent('.icon-list').next('input').val(icon_class).trigger('change');
    });

    $('body').on('click', '.selected-icon', function(){
        $(this).next().slideToggle();
    });

});
