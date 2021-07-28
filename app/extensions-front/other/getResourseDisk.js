(function($){
    "use strict";
    //uri для запросов
    var uri = '/storage/getResourse/';
    //Счетчик для ограничения ajax запросов
    var count = 3;
    var path = '';
    var controlls = $('.control-panel.dir').parent().html();
    //Для файлов убираем ненужные элементы управления 
    $('.control-panel.dir').find('i').each(function(e) {
        
    })
    var controlls_file = $('.control-panel').parent().html();
    //
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
                            if (elem.data("type") == "dir" && count != 0 && path != elem.data('path')) {
                                path = elem.data('path');
                                    count--;
                                 ajaxDataTransfer('path=' + elem.data('path'), elem, collapse, controlls, controlls_file);
                             } 
                    }

                    $(this).on('show.bs.collapse', function (e) {
                                elem.first().addClass('active');
                            icon.removeClass().addClass('icon-folder-open');
                          })
            })
    });         
  /* jquery function transmission data on form*/
  function ajaxDataTransfer (path, elem, collapse, controlls, controlls_file) {
        $.ajax ({
            type: 'POST',
            url:uri,
            data:path,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                elem.append('  <i class="ajax-loader icon-folder-download"></i>');
            },
            success:  function (data) {
                elem.find('.ajax-loader').remove();
                if(data) {
                    if(data.status == true){
                            //Очистка елемента
                            collapse.empty();
                                    $.each(data.data, function (index, value){
                                        if(value.type == "dir") {
                                                    var divList = "<div class='row dynamic'><div class='col-md-12'><ul class='collapse pl-25'></ul></div></div>";
                                                    var icon = "<i class='icon-folder2'></i>";
                                                        collapse.append("<li><div class='row no-pad static'><div class='col-md-6 text-left'><span id='"+value.resourse_id +"' class = 'arrow-collapse  menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span></div><div class='col-md-3'>"+controlls+"</div><div class='col-md-3 text-right'><span >  " +value.date+" | "+ value.time+"</span></div></div>"+divList+"</li>");
                                                }else if (value.type == "file") {
                                                    var icon = "<i class='icon-files'></i>";
                                                        collapse.append("<li><div class='row no-pad static'><div class='col-md-6 text-left'><span id='"+value.resourse_id +"' class = 'arrow-collapse collapsed menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span></div><div class='col-md-3'>"+controlls_file+"</div><div class='col-md-3 text-right'><span class='text-right'>  " +value.date+" | "+ value.time+"</span></div></div></li>");
                                                }
                                    })
                                collapse.collapse('show');
                            count = 3;
                    }else {
                        if (data.status == false) {
                                    collapse.empty().append("<li><i class='icon-file-empty2'></i> Папка пустая...</li>");
                                collapse.collapse('show');
                            count = 3;
                        }
                    }
                }
            },
            error: function(x, t, e){
                if( t === 'timeout') {}
            }
        })
    }          
})(jQuery);
