(function (){
    'use strict';
    var uri = '/storage/deleteResourse/';
    //Update storage resourses
   $('.diskYandex').on('click', 'i.controlls', function () {
       var target = $(this).data('target');
       var resourse = $(this).closest('li').children('.static').find('.arrow-collapse');
       var rootElem = $(this).closest('li');
       
       if(target == 'delete') {
           swal({
                            title: "Удалить",
                            text: "Вы точно хотите удалить ресурс?",
                            icon: "warning",
                            buttons: ["Нет", "Удалить!"],
                            dangerMode: true,
                    })
                            .then((willDelete) => {
                                    if (willDelete) {
                                                ajaxDataRequest(uri,'path='+resourse.data('path'), resourse, deleteCallback);
                                    }
                            });
                    }
   
   //Функция обработчик результатов ajax запроса
   function deleteCallback (data) {
                if(data) {
                    if(data.status == true){
                        //Плавное удаление элемента. Сперва прячем, затем удаляем
                        rootElem.slideUp('slow', function () {
                                $(this).remove();
                            });
                       //Выводим оповещение     
                       notify("Ресурс * "+resourse.data('path')+" * удален", "success");     
                    }else if (data.status == 'empty') {
                                   
                    }else if (data.status == 'error') {
                        errorApiHandler(data.data);
                    }
                }
        }    
    });  
})();

