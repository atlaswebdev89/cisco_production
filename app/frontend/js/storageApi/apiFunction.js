/* AJAX get data RESOURSE for yandex storage*/
function ajaxDataRequest (uri, data, elem, callback, beforeSend = 0) {
        $.ajax ({
            type: 'POST',
            url:uri,
            data:data,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                if(beforeSend != 0) {
                    beforeSend();
                }
            },
            success:  function (data) {
                callback(data);
            },
            error: function(x, t, e){
                if( t === 'timeout') {}
            }
        })
    } 

