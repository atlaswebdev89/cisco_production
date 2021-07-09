$(document).ready(function(){
    $('#logout_button').click(function (event) {
        event.preventDefault();
        if(confirm("Действительно хотите выйти?")){
            var id = $(this).data("id-point");
            ajaxdatasend($(this), id);
        };
    })

    function ajaxdatasend (button, id){
        $.ajax ({
            type: 'POST',
            url:'/point/delete',
            data: {id:id},
            timeout: 5000,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                button.attr('disabled', 'disabled');
            },
            success:  function (data) {
                if(data) {
                    //Если аутентификация прошла перенаправляем на страницу входа
                    if(data.status == true){
                        alert("Точка удалена");
                        window.location.href = data.url;
                    }else if (data.status == false){
                        alert("Ошибка удаления. Попробуйте позже");
                        button.removeAttr('disabled');
                    }else if (data.status == 'NotFoundPoint'){
                        alert("Точки нет в БД");
                        button.removeAttr('disabled');
                    }
                }
            }
        })
    }
})