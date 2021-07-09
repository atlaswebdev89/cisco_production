<?php


namespace Controller;



class PointControllerEdit extends PointController
{
    public $pointData;
    protected $placemark_color;

    public function execute($request, $response, $args)
    {
        return $this->display($request, $response, $args);
    }

    //Функция редактирование данных точки при POST запросе
    public function edit($request, $response, $args)
    {
        //Получение POST запроса при редактировании точки
        if ($request->isPost()) {
            //Редактирование данных точки в БД
            if ($data = $this->editpointbd($request, $response, $args)) {
                return $response->withJson(array('url' => $this->urlPointShow . $data, 'status' => TRUE));
            } else {
                return $response->withJson(array('url' => FALSE, 'status' => FALSE, 'message' => 'Ошибка. Попробуйте еще раз'));
            };
        }

    }

    protected function display($request, $response, $args)
    {
        //Получаем id точки доступа из uri
        $this->id = $args['id'];

        //проверка существует ли точка с указаным id, если нет выдает 404 ошибку
        if (!$this->checkPoint($this->id)) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        };
        //Получение данных точки
        $this->pointData = $this->getDataPointId($this->id);

        //Данные для карты YandexMapsApi
        $this->latitude = ($this->pointData[0]['latitude']);
        $this->longitude = ($this->pointData[0]['longitude']);

        //Хинт и баллун
        $this->ssid = ($this->pointData[0]['ssid']);
        $this->ip = ($this->pointData[0]['ip']);
        $this->businness = ($this->pointData[0]['name']);
        $this->placemark_color = ($this->pointData[0]['placemark_color']);

        $this->title .=  $this->ip;
        $this->page_script = $this->getScripts();
        $this->page_style = $this->getStyles();
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar()
    {
        return $this->view->fetch('template_point_edit_data.php',
            [
                'point_data' => $this->pointData,
                'address' => $this->getAddressForSelect(),
                'business' => $this->getBusinessForSelect(),
                'models' => $this->getModelCiscoForSelect(),
                'ssid' => $this->getSsidForSelect(),
                'speed' => $this->getSpeedForSelect(),
                'placemark_color' => $this->placemark_color,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'ip' => $this->ip,
                'idPoint' => $this->id,
                'ssidName' => $this->ssid,
                'businnessName' => $this->businness
            ]);
    }

    //Получить необходимые стили для отображения страницы
    protected function getStyles()
    {
        return [
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css'
        ];
    }

    //Получить необходимые скрипы для отображения страницы
    protected function getScripts()
    {
        return [
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js',
            '/js/jquery.ipmask.js',
            '/js/jquery.maskedinput.min.js',
            'https://api-maps.yandex.ru/2.1/?apikey=e47ca267-409d-4f76-b09a-2c71c39d6c14&lang=ru_RU',
            '/js/editpoint.js',
            '/js/maps-point-edit.js'
        ];
    }

    //Функция получения данных точки по id из бд
    protected function getDataPointId($id)
    {
        return $this->model->getDataPointId($id);
    }

    protected function getAddressForSelect()
    {
        return $this->model->getAddressForSelect();
    }

    protected function getBusinessForSelect()
    {
        return $this->model->getBusinessForSelect();
    }

    protected function getModelCiscoForSelect()
    {
        return $this->model->getModelCiscoForSelect();
    }

    protected function getSsidForSelect()
    {
        return $this->model->getSsidForSelect();
    }

    protected function getSpeedForSelect()
    {
        return $this->model->getSpeedForSelect();
    }

    protected function editpointbd($request, $response, $args)
    {

        $posts_data = $request->getParsedBody();

        //Очистка данных от всего лишнего
        foreach ($posts_data as &$data) {

            $data = $this->clear_str($data);
        }
        //Проверка типов (метод родительского класса)
        $posts_data = $this->CheckTypeGetId($posts_data);
        //Формирование массива
        $data = $this->getdatainBd($posts_data);

        //Добавлем в массив id точки, которую редактируем
        $data ['id'] =(int)$posts_data['id'];
        
        //Изменение данных точки в БД
        $this->model->editdatapointBd($data);
        return (int)$posts_data['id'];
    }





}