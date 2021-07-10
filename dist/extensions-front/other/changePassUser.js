$(document).ready(function(){  
    //Активация кнопки Изменить при заполнении всех полей
    $('#newpassRep, #oldpass, #newpass').on('keyup', function() {
        var button = $(this).parents('form').find('input[type="button"]');
        checkParams(button);
});
    //функция активации кнопки после заполения всех полей input
    function checkParams(button) {
                var oldpass = $('#oldpass').val();
                var newpass = $('#newpass').val();
                var newpassRep = $('#newpassRep').val();
                    if(oldpass.length != 0 && newpass.length != 0 && newpassRep.length != 0) 
                    {
                        button.removeAttr('disabled');
                    } else {
                        button.attr('disabled', 'disabled');
                    }
    }
    
    //Функция выхода с сайта 
   function ajaxLogOut (){
		$.ajax ({
			type: 'POST',
			url:'/login',
			data: {logout:true},
			timeout: 5000,
			//Указывая тип json использовать функцию JSON.parse не надо будет ошибка
			dataType: "json",
			
			success:  function (data) {
				if(data) {
					if(data.status == true){
						window.location.href = data.url;
					}else if (data.status == false){
						swal("Ошибка", "Ошибка logout", "error");						
					}
				}
			}
		})
	}
        
        
    function ajaxdatasend (form, formdata=null){
        $.ajax ({
            type: 'POST',
            url:'/profileUserPass/',
            contentType: false,
            processData: false,
            data:formdata,
            timeout: 5000,
            //Указывая тип json использовать функцию JSON.parse не надо будет ошибка
            dataType: "json",
            beforeSend: function (data) {
                //Блокируем кнопку и элементы формы
                form.find('input').attr('disabled', 'disabled');
            },
            success:  function (data) {
                if(data) {
                    //Если данные обновились
                    if(data.status == true){
                        ajaxLogOut();
                        return false;
                    }
                    //Очистка формы
                    form[0].reset();
                    //Включение кнопки и элементов формы
                    form.find('input').removeAttr('disabled');
                    form.find('input[type="button"]').attr('disabled', 'disabled');
                    form.find('.input-success').removeClass('input-success');              
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
    
    
    
    
    $('#passChangeUser').click(function() {   
        var newPass = $('#newpass').val();
        var RepPass = $('#newpassRep').val();
        //Проверяем совпадение паролей нового и подтверждение нового пароля 
        if (newPass != RepPass) {            
            $(this).parents('form').find('.response_order p, #response_order p').html('Несовпадение паролей');
            $(this).parents('form').find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 2000);
                return false;
        } 
        //Проверяем длину пароля
        if (newPass.length < 7 || RepPass.length<7) {
            $(this).parents('form').find('.response_order p, #response_order p').html('Минимальная длина пароля 8 знаков');
            $(this).parents('form').find('.response_order p').css("color", "#ffffff").fadeIn("slow");
                setTimeout(function() { $('.response_order p, #response_order p').fadeOut("slow"); }, 2000);
                return false;
        }
        
            var formData = new FormData();
            $(this).parents('form').find('input').each(function()
            {
                formData.append($(this).attr('name'), $(this).val());
            });              
           ajaxdatasend($(this).parents('form'),formData)
           
           
            
        
    });
})
