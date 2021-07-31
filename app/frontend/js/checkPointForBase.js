(function() {
"use strict";
    document.addEventListener('DOMContentLoaded', function() {   

        //Обработчик для проверки наличия указаного ip в базе данных
        $('#ip').blur (function() {

            var input = $(this);
            var ipAddr = $(this).val();
            //формируем объект данных
            var formData = new FormData();
            formData.append('ip', ipAddr);

            var l = input.val().length;

            if (typeof (ip) != "undefined" && ip !== null) {
                if(ip!=ipAddr) {
                    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddr)) {
                        checkData(input,formData);
                    }
                }
            }else {
                    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipAddr)) {
                         checkData(input,formData);
                }
            }
        })
                    //Функция проверки ip в БД (отправка ajax запроса к бекэнду)
                    function checkData(input,formData) {
                        $.ajax ({
                            type: 'POST',
                            url:'/point/checkIpPoint',
                            contentType: false,
                            processData: false,
                            data:formData,
                            timeout: 5000,
                            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
                            dataType: "json",
                            beforeSend: function (data) {
                                //Блокируем кнопку и элементы формы
                                input.attr('disabled', 'disabled');
                            },
                            complete: function () {
                                input.removeAttr('disabled');
                            },
                            success:  function (data) {
                                if(data) {
                                    swal("Ошибка", "Ip уже есть в базе", "error");
                                    input.val('');
                                }}
                        })

                    }
    });
})();
