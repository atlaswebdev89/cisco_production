<?php

namespace Controller;

class PointControllerShow extends PointController {
    
    public $data;
    public $id;
    //переменные для передачи в js YandexMapsApi
    public $latitude;
    public $longitude;
    public $ssid;
    public $ip;
    public $businness;
    protected $placemark_color;
    //uri для редактирования и удаления
    protected $uri_delete_point;
    protected $uri_edit_point;
    
    //uri для отображения на общей карте
    protected $uri_maps;




    public function execute ($request, $response, $args) {
            return $this->display($request, $response, $args);
    }

    protected function display($request, $response, $args) {


            //Получаем id точки доступа из uri
            $this->id = $args['id'];
            
            //проверка существует ли точка с указаным id, если нет выдает 404 ошибку
            if(!$this->checkPoint($this->id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            };

            //Формирование разрешения для отображения блоков в зависимости от роли
            $this->getBlockShowRole();

            //Получаем данные точки по указаному id из бд
            $this->data = $this->getDataPointId($this->id);

            //Формируем сссылки для удаления и редактирования
            $this->uri_delete_point = '/point/delete/id/'.$this->id;
            $this->uri_edit_point   = '/point/edit/id/'.$this->id;
            $this->uri_maps = '/point/maps/id/'. $this->id;

            //Данные для карты YandexMapsApi
            $this->latitude = ($this->data[0]['latitude']);
            $this->longitude = ($this->data[0]['longitude']);

            //Хинт и баллун
            $this->ssid = ($this->data[0]['ssid']);
            $this->ip = ($this->data[0]['ip']);
            $this->businness = ($this->data[0]['name']);
            $this->placemark_color = ($this->data[0]['placemark_color']);

            //Подключение необходимых скриптов
            $this->page_script = $this->getScripts();

            $this->title .=  $this->ip;
            $this->mainbar = $this->mainBar();
            parent::display($request, $response, $args);


    }
    //Получение главного блока данных точки доступа
    protected function mainBar () {
          return $this->view->fetch('template_point_show_data.php',[
                                            'dataPoint'             => $this->data,
                                            'longitude'             => $this->longitude,
                                            'latitude'              => $this->latitude,
                                            'ip'                    => $this->ip,
                                            'ssid'                  => $this->ssid,
                                            'businness'             => $this->businness,
                                            'placemark_color'       => $this->placemark_color,
                                            'delete'                => $this->uri_delete_point,
                                            'edit'                  => $this->uri_edit_point,
                                            'show_block_admin'      => $this->showBlockadmin,
                                            'show_block_moderator'  => $this->showBlockmoderator,
                                            'id'                    => $this->id,
                                            'maps'                  => $this->uri_maps
                                        ]);       
    }

    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            'https://api-maps.yandex.ru/2.1/?apikey=e47ca267-409d-4f76-b09a-2c71c39d6c14&lang=ru_RU',
            '/js/maps-point.js',
            '/js/point-del.js'
        ];
    }



    //Функция получения данных точки по id из бд
    protected function getDataPointId ($id) {
        return $this->model->getDataPointId($id);

    }



}
