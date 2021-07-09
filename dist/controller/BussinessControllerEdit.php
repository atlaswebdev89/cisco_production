<?php


namespace Controller;


class BussinessControllerEdit extends BussinessController
{

    protected $dataBus;

    public function execute($request, $response, $args)
    {
        return $this->display($request, $response, $args);
    }

    //Функция редактирование данных организации при POST запросе
    public function edit($request, $response, $args)
    {
        //Получение POST запроса при редактировании точки
        if ($request->isPost()) {
            //Редактирование данных точки в БД
            if ($data = $this->editBusbd($request, $response, $args)) {
                return $response->withJson(array('url' =>'/bussiness', 'status' => TRUE));
            } else {
                return $response->withJson(array('url' => FALSE, 'status' => FALSE, 'message' => 'Ошибка. Попробуйте еще раз'));
            };
        }

    }

    protected function editBusbd($request, $response, $args)
    {
        $posts_data = $request->getParsedBody();
        //Очистка данных от всего лишнего
        foreach ($posts_data as &$data) {
            $data = $this->clear_str($data);
        }
        //Изменение данных организации в БД
        if ($this->model->editBussinessdata($posts_data)){
            return TRUE;
        }else
            return FALSE;
    }

    public function display($request, $response, $args)
    {
        //Получаем id точки доступа из uri
        $this->id = $args['id'];

        //проверка существует ли точка с указаным id, если нет выдает 404 ошибку
        if (!$this->checkBussiness($this->id)) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        };
        //Получение данных точки
        $this->dataBus = $this->getDataBussId($this->id);

        //Получение всех точек текущей организации
        $points = $this->getPointBussId( $this->id);

        $this->page_script = $this->getScripts();

        $this->title .= $this->dataBus[0]['name'];
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar()
    {
        return $this->view->fetch('template_bussiness_edit.php',
            [
                'data' => $this->dataBus,
                'idBus' => $this->id
            ]);
    }

    protected function getScripts()
    {
        return [

            '/js/bussiness-edit.js',
            '/js/jscolor.js'
        ];
    }

    protected function getDataBussId ($id){
        return $this->model->getDataBussId($id);
    }

    protected function checkBussiness($id){
        return $this->model->checkBussiness($id);
    }

    protected function getPointBussId($id) {
        return $this->model->getPointBussId($id);
    }
}