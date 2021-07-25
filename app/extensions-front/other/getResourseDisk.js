(function($){
    "use strict";
    //<i class="icon-folder-open"></i>
    let uri = '/storage/getResourse/';
    
    //Для динамических элементов страницы (добавленных черех ajax или append)
    //используем делегированную обработку событий
    $('.diskYandex').on('click', ".arrow-collapse", function (e) {
       let elem = $(this);
            $(this).closest('li').children('.collapse').each(function (e) {
                if($(this).find('li').length > 0) {
                        $(this).collapse('toggle');
                }else {
                        if (elem.data("type") == "dir") {
                             ajaxDataTransfer('path=' + elem.data('path'), elem);
                         } 

                }
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
                //form.find('button, input, textarea').attr('disabled', 'disabled');
            },
            success:  function (data) {
                if(data) {
                    if(data.status == true){
                            let divElem = elem.closest('li').children('.collapse');
                            //Очистка елемента
                                $.each(data.data, function (index, value){
                                    if(value.type == "dir") {
                                                var divList = "<ul class='collapse pl-25' id = '"+value.resourse_id+"'></ul>";
                                                var icon = "<i class='icon-folder2'></i>";
                                            }else if (value.type == "file") {
                                                var icon = "<i class='icon-files'></i>";
                                            }
                                        divElem.append("<li><span class = 'arrow-collapse active collapsed' data-toggle='collapse' data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span><span class='text-right'>" +value.date+"</span>"+divList+"</li>");
                                })
                            divElem.collapse('toggle');
                    }else {
                        if (data.status == false) {
                            let divElem = elem.closest('li').children('.collapse');
                                divElem.append("<li><i class='icon-file-empty2'></i> Папка пустая...</li>");
                            divElem.collapse('toggle');
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
