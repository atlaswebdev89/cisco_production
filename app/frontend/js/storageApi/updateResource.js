(function(){
    var uri = '/storage/getResourse/';
   //Update storage resourses
   $('.diskYandex').on('click', 'i.controlls', function () {
        var target = $(this).data('target');
        $(this).closest('li').children('.static').find('.arrow-collapse').each(function(){
            var elem = $(this);
            var icon = $(this).find('i');
            var collapse = $(this).closest('li').children('.dynamic').children('div').children('.collapse'); 
            
            if(target == 'update' && count_ajax != 0) {
                    count_ajax = count_ajax-3;
                        ajaxDataRequest(uri,'path='+$(this).data('path'), $(this), getResourceCallback, beforeSendCallback);

                collapse.on('show.bs.collapse', function (e) {
                                                elem.addClass('active');
                                                icon.removeClass().addClass('icon-folder-open');
                                          })
                            }
        //Функция до обработчика    
        function beforeSendCallback () {
            elem.append('  <i class="ajax-loader icon-loading"></i>');
        }    
        //Функция обработчик результатов ajax запроса
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
                            count_ajax = 3; path = '';
                    }else if (data.status == 'empty') {
                                    collapse.empty().append("<li class='request-empty'><i class='icon-file-empty2'></i> Папка пустая...</li>");
                                collapse.collapse('show');
                            count_ajax = 3; path = '';
                    }else if (data.status == 'error') {
                        errorApiHandler(data.data);
                    }
                }
            }     
        });
    });
})();


