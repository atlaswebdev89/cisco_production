//Если заданы координаты точки формируем карту, если нет карта не нужна
if (latitude && longitude) {
            ymaps.ready(init);

            function init() {
                var map = new ymaps.Map('map', {
                    center: [latitude, longitude],
                    zoom: 18,
                    controls: [
                        'fullscreenControl',
                        'zoomControl'
                    ],
                    behaviors: ['drag', 'multiTouch']
                });
                var myPlacemark = new ymaps.Placemark([latitude, longitude],
                    {
                        hintContent: ssid,
                        balloonContent:
                            [
                                '<div style="text-align: center">',
                                '<span>Организация - ' + businness + '</span><br />',
                                '<span>Название сети - ' + ssid + '</span><br />',
                                '<span>IP адресс - ' + ip + '</span>',
                                '</div>'
                            ].join(''),
                        iconCaption: ssid
                    },
                    {
                        iconColor: placemark_color
                    });

                // Добавляем метку на карту
                map.geoObjects.add(myPlacemark);
            }
}else {
    $('#map, #allMapsButton').remove();
}