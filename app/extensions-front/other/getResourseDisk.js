(function($){
    "use strict";
        var uri = '/storage/getResourse/';
        var path = '';
    //Для динамических элементов страницы (добавленных черех ajax или append)
    //используем делегированную обработку событий
    $('.diskYandex').on('click', "span.arrow-collapse", function (e) {
       
        var elemClick = $(this).attr('id');
        var elem = $(this);
        var icon = $(this).find('i');
        var collapse = elem.closest('li').children('.dynamic').children('div').children('.collapse');      
         
            if($(this).hasClass('active')) {
                        elem.removeClass('active');
                    icon.removeClass().addClass('icon-folder2');
                }
            
            collapse.each(function (e) {
                    if($(this).find('li').length > 0) {
                            $(this).collapse('toggle');
                    }else {
                            if (elem.data("type") == "dir" && count_ajax != 0 && path != elem.data('path')) {
                                path = elem.data('path');
                                    count_ajax--;
                                 ajaxDataTransfer(uri, 'path=' + elem.data('path'), elem, collapse, controlls, controlls_file);
                             } 
                    }

                    $(this).on('show.bs.collapse', function (e) {
                                elem.first().addClass('active');
                            icon.removeClass().addClass('icon-folder-open');
                          })
            })
    });
})(jQuery);

