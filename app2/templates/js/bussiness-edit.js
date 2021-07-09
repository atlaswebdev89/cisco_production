$(document).ready(function(){
    var name = $('#name').val();
    var color = $('#color').val();
    var description = $('#description').val();
    var urlRedirect = '/bussiness';

    $('#button-edit-bussiness').click(function() {
        //переменная formValid
        var formValid = true;
        var id = $(this).data("id-bussiness");
        //перебрать все элементы управления input
        $(this).parents('form').find('input').each(function() {
            //найти предков, которые имеют класс .form-group, для установления success/error
            var formGroup = $(this).parents('.form-group');
            //для валидации данных используем HTML5 функцию checkValidity
            if (this.checkValidity()) {
                //добавить к formGroup класс .has-success, удалить has-error
                $(this).addClass('input-success').removeClass('input-error');
            } else {
                //добавить к formGroup класс .has-error, удалить .has-success
                $(this).addClass('input-error').removeClass('input-success');
                //отметить форму как невалидную
                formValid = false;
            }
        });
        if (!formValid==false) {
            var formData = new FormData();
            formData.append('id', id);
            $(this).parents('form').find('input').each(function()
            {
                formData.append($(this).attr('name'), $(this).val());
            });

            //Проверка изменились ли значения полей формы. Если нет просто возраваемся назад. Если да - делаем запрос на Back-end
            if(formData.get('name') != name || formData.get('color') != color || formData.get('description') != description)
            {
                ajaxdatasend($(this).parents('form'),formData)
            }else {
                window.location.href =  urlRedirect;
            }
        }
    });

    function ajaxdatasend (form, formdata=null){
        $.ajax ({
            type: 'POST',
            url:'/bussiness/edit/',
            contentType: false,
            processData: false,
            data:formdata,
            timeout: 5000,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                form.find('button,input,select').attr('disabled', 'disabled');
            },
            success:  function (data) {
                if(data) {
                    //Если данные измененны делаем редирект
                    if(data.status == true){
                        history.back();
                    }
                    //Очистка формы
                    form[0].reset();
                    //Включение кнопки и элементов формы
                    form.find('button,input,select').removeAttr('disabled');
                    form.find('.input-success').removeClass('input-success');
                    form.find ('button span').html();
                    form.find('.response_order p, #response_order p').html(data.message);
                    form.find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                    setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 2000);
                }
            },
            error: function(x, t, e){
                if( t === 'timeout') {
                    // Произошел тайм-аут
                    form[0].reset();
                    //Включение кнопки и элементов формы
                    form.find('button,input,select').removeAttr('disabled');
                    form.find('.input-success').removeClass('input-success');
                    form.find ('button span').html();
                    form.find('.response_order p, #response_order p').html('Превышено время ожидания');
                    form.find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                    setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 2000);
                }
            }
        })
    }






})