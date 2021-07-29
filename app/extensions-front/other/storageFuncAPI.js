//Счетчик для ограничения ajax запросов
var count_ajax = 3;
var controlls = {
       download:'icon-download2',
       upload:'icon-upload2',
    };
    
var controlls = $('.control-panel.dir').parent().html();
var controlls_file = controlls;

/* AJAX get data RESOURSE for yandex storage*/
function ajaxDataTransfer (uri, path, elem, collapse, controlls, controlls_file) {
        $.ajax ({
            type: 'POST',
            url:uri,
            data:path,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                elem.append('  <i class="ajax-loader icon-loading"></i>');
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
                                                        collapse.append("<li><div class='row no-pad static'><div class='col-md-6 text-left'><span id='"+value.resourse_id +"' class = 'arrow-collapse  menu-expand'  data-path ='"+value.path+"' data-type = '"+value.type+"'>" +icon+ " "  +value.name+"</span></div><div class='col-md-3'>"+controlls+"</div><div class='col-md-3 text-right'><span >  "+ value.time+"  | " +value.date+"</span></div></div>"+divList+"</li>");
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
            },
            error: function(x, t, e){
                if( t === 'timeout') {}
            }
        })
    }  
    
  