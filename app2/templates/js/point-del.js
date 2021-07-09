$(document).ready(function() {
    //Удаление по id ссылка в карточке точки wifi
    $('#point_del').click(function (event) {
        event.preventDefault();
        var id = $(this).data("id-point");
        ConfirmSweet(ajaxdatasend, $(this), id);

    })

    //Удаление в общем списке без редиректа
    $('.point_del').click(function (event) {
        event.preventDefault();
        var id = $(this).data("id-point");
        ConfirmSweet(ajaxPointDel, $(this), id);
    })

    function ajaxdatasend(button, id) {
        $.ajax({
            type: 'POST',
            url: '/point/delete',
            data: {id: id},
            timeout: 5000,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                button.attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data) {
                    //Если ошибки нет делаем перенаправление
                    if (data.status == true) {
                        swal({
                            title: "Good!",
                            text: "Точка удалена",
                            confirmButtonText: "OK"
                        }).then((WillDelete) => {
                            if (WillDelete == true || WillDelete == null) {
                                window.location.href = data.url;
                            }
                        })

                        //Если доступ закрыт делаем перенаправление на страницу загрушку
                    } else if (data.status == 'denied') {
                        window.location.href = data.url;
                    } else if (data.status == false) {
                        swal("Ошибка", "Ошибка удаления. Попробуйте позже", "error");
                        button.removeAttr('disabled');
                    } else if (data.status == 'NotFoundPoint') {
                        swal("Ошибка", "Точки нет в БД", "error");
                        button.removeAttr('disabled');
                    }
                }
            }
        })
    }

    function ajaxPointDel(button, id) {
        $.ajax({
            type: 'POST',
            url: '/point/delete',
            data: {id: id},
            timeout: 5000,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                button.attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data) {
                    //Если ошибки нет делаем перенаправление
                    if (data.status == true) {
                        button.closest('.parent-block').hide(600);
                        //Если доступ закрыт делаем перенаправление на страницу загрушку
                    } else if (data.status == 'denied') {
                        window.location.href = data.url;
                    } else if (data.status == false) {
                        swal("Ошибка", "Ошибка удаления. Попробуйте позже", "error");
                        button.removeAttr('disabled');
                    } else if (data.status == 'NotFoundPoint') {
                        swal("Ошибка", "Точки нет в БД", "error");
                        button.removeAttr('disabled');
                    }
                }
            }
        })
    }

    function ConfirmSweet(nameFunc, button, id) {
        swal({
            title: "Удалить точку?",
            text: "Подтвертить удаление точки Cisco!",
            icon: "warning",
            buttons: ["Отменить", "Удалить!"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    nameFunc(button, id);
                }
            });
    }
})