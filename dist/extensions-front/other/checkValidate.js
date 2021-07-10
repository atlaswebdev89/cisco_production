//Путь до файла отправки почты через smtp
var UrlLogin = '/login';

/*Фунция передачи параметров через ajax для отправки почты*/
function ajaxdatasend (form, formdata=null)
    {
        $.ajax ({
                       type: 'POST',
                       url:UrlLogin,
                       contentType: false,
                       processData: false, 
                       data:formdata,
                       timeout: 5000,
                        //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
                       dataType: "json",
                       beforeSend: function (data) { 
                                    //Блокируем кнопку и элементы формы
                                    form.find('button,input').attr('disabled', 'disabled'); 
                       },
                       success:  function (data) { 
                           if(data) {
                                //Если аутентификация прошла перенаправляем на страницу входа
                                if(data.status == true){
                                    window.location.href = data.url;
                               }
                                    //Очистка формы
                                    form[0].reset();
                                    //Включение кнопки и элементов формы
                                    form.find('button,input').removeAttr('disabled'); 
                                    form.find('.form-group').removeClass('has-success');
                                    form.find ('button span').html();
                                                form.find('.response_order p, #response_order p').html(data.message);
                                                form.find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                                                setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 3000);
                           }
                       },
                       error: function(x, t, e){
                            if( t === 'timeout') { 
             // Произошел тайм-аут
                           form[0].reset();
                                    //Включение кнопки и элементов формы
                                    form.find('button,input').removeAttr('disabled'); 
                                    form.find('.form-group').removeClass('has-success');
                                    form.find ('button span').html();
                                                form.find('.response_order p, #response_order p').html('Превышено время ожидания');
                                                form.find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                                                setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 3000);
                            }
                           }
                   }) 
    }
//Проверка формы checkValidity     
jQuery(document).ready(function ($) {
    //при нажатии на кнопку "Вход"
        $('#loginform').click(function() {
                  //переменная formValid
                  var formValid = true;  
                  //перебрать все элементы управления input 
                  $(this).parents('form').find('input').each(function() {
                                              //найти предков, которые имеют класс .form-group, для установления success/error
                                              var formGroup = $(this).parents('.form-group');
                                                
                                              //для валидации данных используем HTML5 функцию checkValidity
                                                if (this.checkValidity()) {
                                                //добавить к formGroup класс .has-success, удалить has-error
                                                        formGroup.addClass('has-success').removeClass('has-error');
                                                } else {
                                                //добавить к formGroup класс .has-error, удалить .has-success
                                                        formGroup.addClass('has-error').removeClass('has-success');
                                                //отметить форму как невалидную 
                                                        formValid = false;  
                                              }
                                            });
                                            
                                            //формируем объект данных
                                            var formData = new FormData();     
                                            if (!formValid==false)
                                            {
                                                
                                                $(this).parents('form').find('input').each(function() 
                                                    {
                                                        formData.append($(this).attr('name'), $(this).val());
                                                    });
                                             ajaxdatasend($(this).parents('form'),formData)
                                            }
        });
  });
    
