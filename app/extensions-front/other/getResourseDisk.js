(function($){
    "use strict";
    //uri для запросов
    let uri = '/storage/getResourse/';
    //Счетчик для ограничения ajax запросов
    let count = 3;
    let path = '';
    //Для динамических элементов страницы (добавленных черех ajax или append)
    //используем делегированную обработку событий
    $('.diskYandex').on('click', "span.arrow-collapse", function (e) {
        var elemClick = $(this).attr('id');
        var elem = $(this);
        var icon = $(this).find('i');
              
            if($(this).hasClass('active')) {
                    elem.removeClass('active');
                    icon.removeClass().addClass('icon-folder2');
                }
                
            elem.parent('li').children('.collapse').each(function (e) {
                    if($(this).find('li').length > 0) {
                            $(this).collapse('toggle');
                            
                    }else {
                            if (elem.data("type") == "dir" && count != 0 && path != elem.data('path')) {
                                path = elem.data('path');
                                    count--;
                                 ajaxDataTransfer('path=' + elem.data('path'), elem);
                             } 
                    }

                    $(this).on('show.bs.collapse', function (e) {
                                elem.first().addClass('active');
                            icon.removeClass().addClass('icon-folder-open');
                          })
            })
    });         
  /* jquery function transmission data on form*/
  function ajaxDataTransfer (path, elem) {
        $.ajax ({
            type: 'POST',
            url:uri,
            data:path,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
            },
            success:  function (data) {
                if(data) {
                    if(data.status == true){
                            let divElem = elem.closest('li').children('.collapse');
                            //Очистка елемента
                            divElem.empty();
                                    $.each(data.data, function (index, value){
                                        if(value.type == "dir") {
                                                    var divList = "<ul class='collapse pl-25'></ul>";
                                                    var icon = "<i class='icon-folder2'></i>";
                                                        divElem.append("<li><span id='"+value.resourse_id +"' class = 'arrow-collapse collapsed menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span><span class='text-right'>  (" +value.date+" | "+ value.time+")</span>"+divList+"</li>");
                                                }else if (value.type == "file") {
                                                    var icon = "<i class='icon-files'></i>";
                                                        divElem.append("<li><span id='"+value.resourse_id +"' class = 'arrow-collapse collapsed menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span><span class='text-right'>  (" +value.date+" | "+ value.time+")</span></li>");
                                                }
                                    })
                                divElem.collapse('show');
                            count = 3;
                    }else {
                        if (data.status == false) {
                                let divElem = elem.closest('li').children('.collapse');
                                    divElem.empty().append("<li><i class='icon-file-empty2'></i> Папка пустая...</li>");
                                divElem.collapse('show');
                            count = 3;
                        }
                    }
                }
            },
            error: function(x, t, e){
                if( t === 'timeout') {
                   
                }
            }
        })
    }          
})(jQuery);
