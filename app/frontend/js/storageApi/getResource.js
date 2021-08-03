//Счетчик для ограничения ajax запросов
var count_ajax = 3;

var controlls_dir_items = {
       download:    ['icon-download2',  "Скачать"],
      // upload:      ['icon-upload2',    "Загрузить"],
       update:      ['icon-loading',    "Обновить"],
      // rename:      ['icon-tag',        "Переименовать"],
      // add:         ['icon-box-add',    "Создать папку"],
       delete:      ['icon-delete',     "Удалить"]
    };
var controlls_file_items = {
       download:    ['icon-download2',  "Скачать"],
      // rename:      ['icon-tag',        "Переименовать"],
       delete:      ['icon-delete',     "Удалить"]
    };

var controlls_dir ='<span class="control-panel dir">';
    for (let key in controlls_dir_items) {
       controlls_dir +='<i class= "'+controlls_dir_items[key][0]+' controlls" data-target = "'+key+'" data-title="'+controlls_dir_items[key][1]+'"></i> ';
    }
controlls_dir +='</span>';

var controlls_file ='<span class="control-panel file">';
    for (let key in controlls_file_items) {
       controlls_file +='<i class= "'+controlls_file_items[key][0]+' controlls" data-target = "'+key+'" data-title="'+controlls_file_items[key][1]+'"></i> ';
    }
controlls_file +='</span>';

var path = '';

(function($){
    "use strict";
        var uri = '/storage/getResourse/';
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
                                 ajaxDataRequest(uri, 'path=' + elem.data('path'), elem, getResourceCallback, beforeSendCallback);
                             } 
                    }

                    $(this).on('show.bs.collapse', function (e) {
                                elem.first().addClass('active');
                            icon.removeClass().addClass('icon-folder-open');
                          })
            });
            
        //Функция до обработчика    
        function beforeSendCallback () {
            elem.append('  <i class="ajax-loader icon-loading"></i>');
        }    
        //Функиця обработчик результатов ajax запроса
        function getResourceCallback(data) {
             elem.find('.ajax-loader').remove();
                if(data) {
                    if(data.status == true){
                            //Очистка елемента
                            collapse.empty();
                                    $.each(data.data, function (index, value){
                                        if(value.type == "dir") {
                                                    var divList = "<div class='row dynamic'><div class='col-md-12'><ul class='collapse pl-25'></ul></div></div>";
                                                    var icon = "<i class='icon-folder2'></i>";
                                                        collapse.append("<li><div class='row no-pad static'><div class='col-md-6 text-left'><span id='"+value.resourse_id +"' class = 'arrow-collapse  menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span></div><div class='col-md-3'>"+controlls_dir+"</div><div class='col-md-3 text-right'><span >  "+ value.time+"  | " +value.date+"</span></div></div>"+divList+"</li>");
                                                }else if (value.type == "file") {
                                                    var icon = "<i class='icon-files'></i>";
                                                        collapse.append("<li><div class='row no-pad static'><div class='col-md-6 text-left'><span id='"+value.resourse_id +"' class = 'arrow-collapse collapsed menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span></div><div class='col-md-3'>"+controlls_file+"</div><div class='col-md-3 text-right'><span class='text-right'>  "+ value.time+"  | " +value.date+"</span></div></div></li>");
                                                }
                                    })
                                collapse.collapse('show');
                            count_ajax = 3;
                    }else if (data.status == 'empty') {
                                    collapse.empty().append("<li class='request-empty'><i class='icon-file-empty2'></i> Папка пустая...</li>");
                                collapse.collapse('show');
                            count_ajax = 3;
                    }else if (data.status == 'error') {
                        errorApiHandler(data.data);
                    }
                }
        } 
    });
})(jQuery);

