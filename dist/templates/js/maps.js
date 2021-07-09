var myMap, myPlacemark, coords;
ymaps.ready(init);
function init () {
    var map = new ymaps.Map ('map', {
        center: [52.0947,23.6911],
        zoom: 16,
        controls: [
            'fullscreenControl',
            'zoomControl'
        ],
        behaviors:['drag']
    });

     myPlacemark = new ymaps.Placemark([],{ iconContent: '1'},
                                          {
        draggable: true,
        iconColor: 'green',
        iconGlyph: 'home',
        iconGlyphColor: 'blue',
        preset: 'islands#glyphIcon'
        });

        // Добавляем метку на карту
        map.geoObjects.add(myPlacemark);

    //Добавляем кнопку на карту для удаления метки
    var myButton = new ymaps.control.Button({
        data: {
            // Текст на кнопке.
            content: 'Удалить',
            // Текст всплывающей подсказки.
            title: 'Удалить метку с карты'
        },
        options: {
            // Зададим опции кнопки.
            selectOnClick: false
        }
    });
    myButton.events.add('click', function () {
            map.geoObjects.remove(myPlacemark);
            $('#latitude').val('');
            $('#longitude').val('');
        }
    )
    map.controls.add(myButton);

    var suggestView1 = new ymaps.SuggestView('suggest', {
        offset: [-2, 3], // Отступы панели подсказок от её положения по умолчанию. Задаётся в виде смещений по горизонтали и вертикали относительно левого нижнего угла элемента input.
//        width: 420, // Ширина панели подсказок
        results: 8, // Максимальное количество показываемых подсказок.
        boundedBy : [ // Координаты Брестского района
	        [51.97950140188198,25.000236554687426],
	     	[52.01881260476768,24.508495032157118]
        ]
    });

    // При клике по кнопке запускаем верификацию введёных данных.
    $('#button-maps').bind('click', function (e) {
        geocode();
    });
     function geocode() {
         var request = $('#suggest').val();
            var myGeocoder = ymaps.geocode(request);
            myGeocoder.then(function (res) 
                            {
                var coordinates = res.geoObjects.get(0).geometry.getCoordinates();
                map.setCenter(coordinates, 18);    
            });
                            
                            }
    //Отслеживаем событие щелчка по карте
     map.events.add('click', function (e) 
                    {
                        coords = e.get('coords');
                            var xy = [coords[0].toPrecision(6), coords[1].toPrecision(6)];

                                myPlacemark.geometry.setCoordinates(xy);
                                map.geoObjects.add(myPlacemark);

                                $('#latitude').val(coords[0].toPrecision(6));
                                $('#longitude').val(coords[1].toPrecision(6));
                        
    });
    //Отслеживаем событие перемещения метки
		 myPlacemark.events.add("dragend", function (e) {			
			coords = this.geometry.getCoordinates(); 
                        $('#latitude').val(coords[0].toPrecision(6));
                        $('#longitude').val(coords[1].toPrecision(6));
            }, myPlacemark);	
    
   
                            }
                            
    