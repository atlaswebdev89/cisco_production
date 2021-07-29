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
                ajaxDataTransfer(uri,'path='+$(this).data('path'), $(this),collapse,controlls,controlls_file  );
            }
            
            collapse.on('show.bs.collapse', function (e) {
                                elem.addClass('active');
                                icon.removeClass().addClass('icon-folder-open');
                          })
        });
    });
})();


