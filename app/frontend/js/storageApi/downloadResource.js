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
                                        window.location.href = ""+uri+"?path="+resourse.data('path');
                                    }
                            });
                    }
    
    });  
})();



