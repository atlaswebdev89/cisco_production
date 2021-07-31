(function (){
    'use strict';
    var uri = '/storage/downloadResourse/';
    //Update storage resourses
   $('.diskYandex').on('click', 'i.controlls', function () {
       var target = $(this).data('target');
        var resourse = $(this).closest('li').children('.static').find('.arrow-collapse');
        var rootElem = $(this).closest('li');
       
       if(target == 'download') {
           swal({
                            title: "Скачать",
                            text: "Вы хотите скачать "+resourse.data('path')+" ?",
                            icon: "warning",
                            buttons: ["Нет", "Скачать"],
                            dangerMode: true,
                    })
                            .then((willDownload) => {
                                    if (willDownload) {
                                                ajaxDataRequest(uri,'path='+resourse.data('path'), resourse, downloadCallback);
                                    }
                            });
                    }
   
   //Функция обработчик результатов ajax запроса
   function downloadCallback (data) {
                if(data) {
                    if(data.status == true){
                       //Выводим оповещение     
                       notify("Ресурс * "+resourse.data('path')+" * скачан", "success");     
                    }else if (data.status == 'empty') {
                                   
                    }else if (data.status == 'error') {
                        errorApiHandler(data.data);
                    }
                }
        }    
    });  
})();



