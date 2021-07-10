"use strict";

window.addEventListener('load', function() {
//------------------------------------------------------------------------
//						NAVBAR SLIDE SCRIPT
//------------------------------------------------------------------------
$(window).scroll(function () {
    if ($(window).scrollTop() > $("nav").height()) {
        $("nav.navbar").addClass("show-menu");
    } else {
        $("nav.navbar").removeClass("show-menu");
        $("nav.navbar .navMenuCollapse").collapse({
            toggle: false
        });
        $("nav.navbar .navMenuCollapse").collapse("hide");
    }
});

//------------------------------------------------------------------------
//						NAVBAR HIDE ON CLICK (COLLAPSED) SCRIPT
//------------------------------------------------------------------------
//$('.navbar li a').on('click', function() {
//    $('.collapse.in').collapse('hide');
//});
//------------------------------------------------------------------------
//                    MAGNIFIC POPUP(LIGHTBOX) SETTINGS
//------------------------------------------------------------------------

$('.gallery').each(function () { // the containers for all your galleries
    var $this = $(this);
    $this.magnificPopup({
        delegate: 'a.gallery-box:not(.external)', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled: true
        },
        image: {
            titleSrc: function (item) {
                return item.el.find('span.caption').text();
            }
        },
        callbacks: {
            open: function() {
                $this.trigger('stop.owl.autoplay');
            },
            close: function() {
                $this.trigger('play.owl.autoplay');
            }
        }
    });
});

});

window.addEventListener('load', function() {
if (!navigator.userAgent.match(/iPhone|iPad|iPod|Android|BlackBerry|IEMobile/i)) {
	var skr = skrollr.init(
		{
		smoothScrolling: false
		, forceHeight: false
		, mobileDeceleration: 0.004
		}
		);
	}
});

$('.single-iframe-popup').magnificPopup({
	type: 'iframe',
	iframe: {
		patterns: {
			youtube: {
				index: 'www.youtube.com/',
				id: 'v=',
				src: 'https://www.youtube.com/embed/%id%?autoplay=1'
			}
			, vimeo: {
				index: 'vimeo.com/',
				id: '/',
				src: 'https://player.vimeo.com/video/%id%?autoplay=1'
			}
		}
	}
});
$('.single-image-popup').magnificPopup({
	type: 'image'
});


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

  
