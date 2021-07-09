var geoobjects=[];
var nameBussines = [];
ymaps.ready(init);
function init () {
    var map = new ymaps.Map('map', {
        center: [latitude, longitude],
        zoom: zoom,
        controls: [
            'fullscreenControl',
            'zoomControl'
        ],
        behaviors: ['drag', 'multiTouch']
    });

    var clusterer = new ymaps.Clusterer({
        maxZoom: 13
    });

    map.geoObjects.add(clusterer);

    $('select#points').append('<option value="all">Все точки</option>');

    for (var i = 0; i < dataPoint.length; i++) {
        var pointGroup = [];
        // Добавляем название организации в выпадающий список
        if (dataPoint[i].items) {
                $('select#points').append('<option value="' + i + '">' + dataPoint[i].name + '</option>');
                //Массив сопостовления названия Фирмы и идентивикатора массива точек
                nameBussines[dataPoint[i].id] = i;
                // Создаём коллекцию меток для города

                for (var c = 0; c < dataPoint[i].items.length; c++) {
                    var PointInfo = dataPoint[i].items[c];

                    var PointPlacemark = new ymaps.Placemark([PointInfo.latitude, PointInfo.longitude],
                        {
                            hintContent: PointInfo.ssid,
                            balloonContent:
                                [
                                    '<div style="text-align: left">',
                                    '<span>Организация - ' + PointInfo.name + '</span><br />',
                                    '<span>Название сети - ' + PointInfo.ssid + '</span><br />',
                                    '<span>IP адресс - ' + PointInfo.ip + '</span><br />',
                                    '<div style="text-align: center;">',
                                    '<span ><a href ="/point/show/id/' + PointInfo.id + '">Просмотр</a> <a href="/point/edit/id/' + +PointInfo.id + '">Изменить</a> </span>',
                                    '</div>',
                                    '</div>'
                                ].join(''),
                            iconCaption: PointInfo.ssid,
                            clusterCaption: (PointInfo.name)
                        },
                        {
                            iconColor: PointInfo.placemark_color
                        }
                    );
                    pointGroup[c] = PointPlacemark;
                }
                geoobjects[i] = pointGroup;
                clusterer.add(geoobjects[i]);
        }
}
    var searchControl = new ymaps.control.SearchControl({
        options: {
            provider: 'yandex#search'
        }
    });
    map.controls.add(searchControl);

    // масштабирование карты, чтобы влазили все объекты
    if(zoom < 19) {
        map.setBounds(map.geoObjects.getBounds(), {
            checkZoomRange: true
        });
    }
    
    if(idGroupRequest) {
        clusterer.removeAll();
        if (nameBussines[idGroupRequest]) {
            getMarksGroups(nameBussines[idGroupRequest]);
            $("#points").select2().val(nameBussines[idGroupRequest]).trigger('change.select2');
        }
    }

// Переключение точек в зависимости от организаций
$(document).on('change', $('select#points'), function () {
    clusterer.removeAll();
    var PointGroupId = $('select#points').val();  
    getMarksGroups(PointGroupId);
});


    $('#allPoint').click(function () {
        getMarksGroups('all');
        $('#points').val("all");
        $("#points").select2().trigger('change');
    })



 //Функция отображения выбранной группы меток или группы переданой в запросе
 function getMarksGroups (id) {
      if (id=='all') {
       geoobjects.forEach(function(item) {
           clusterer.add(item);
       })
   }else {
              clusterer.add(geoobjects[id]);
   }
   // Масштабируем и выравниваем карту так, чтобы были видны метки для выбранной организации
    map.setBounds(map.geoObjects.getBounds(), {checkZoomRange:true});
 }
}