<?php

namespace Controller;

class PointControllerMaps extends PointController
{
    protected $dataPointAll;
    protected $dataPointJson;
    protected $collections;
    //Default Coordinaties maps;
    protected $x = 52.0947;
    protected $y =23.6911;
    protected $zoom =16;
    protected $id_bussiness;

    public function execute($request, $response, $args)
    {
        if (isset($args['id'])) {
            
            if($result = $this->model->getDataPointId($args['id'])) {
                $this->x = $result[0]['latitude'];
                $this->y = $result[0]['longitude'];
                $this->zoom = 19;               
            }   
        }
        return $this->display($request, $response, $args);
    }
    
    public function showMapsBussiness ($request, $response, $args) {
        if (isset($args['id'])) {
            if (!$this->model->getPointBussId($args['id'])) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }
            $this->id_bussiness = $args['id'];
        }
        return $this->display($request, $response, $args);
    }
        

    protected function display($request, $response, $args)
    {
        $this->title .= 'Maps';
        //Подключение необходимых скриптов
        $this->page_script = $this->getScripts();
        $this->page_style = $this->getStyles();
        //Получение данных всех точек
        $this->dataPointAll = $this->getDataPoint();
       //Получение списка организаций для формирования коллекций (maps API yandex)
        $this->collections = $this->getCollectionBd();

        $this->dataPointJson = $this->getCollections($this->dataPointAll, $this->collections);

       // print_r($this->dataPointJson);exit;
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar () {
        return $this->view->fetch('template_point_maps_page.php',
                                    [
                                        'data'          => $this->dataPointJson,
                                        'latitude'      => $this->x,
                                        'longitude'     => $this->y,
                                        'zoom'          => $this->zoom,
                                        'id_bussiness'  => $this->id_bussiness
        ]);
    }
//Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            'https://api-maps.yandex.ru/2.1/?apikey=e47ca267-409d-4f76-b09a-2c71c39d6c14&lang=ru_RU',
            '/js/maps-show-collections.js',
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js',
            '/js/select2Maps.js'
        ];
    }

    protected function getStyles()
    {
        return [
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css'
        ];
    }

    protected function getDataPoint () {
        return $this->model->getDataPoint();
    }

    protected function getCollectionBd() {
        return $this->model->getBussinessavailable();
    }

    protected function getCollections($allData, $Bussines) {
        $array = array();
        $i=0;

            for ($i; $i < (count($Bussines)); $i++) {
                    $array[$i]['id'] = $Bussines[$i]['id'];
                    $array[$i]['name'] = $Bussines[$i]['name'];
                    $array[$i]['color'] = $Bussines[$i]['placemark_color'];

                    foreach ($allData as $key => $item) {
                        if ($array[$i]['name'] == $item['name']) {
                            $array[$i]['items'][] = $item;
                        }
                    }
        }

        $json = json_encode($array);
        return $json;

    }
}