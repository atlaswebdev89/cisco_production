<?php


namespace Controller;


class BussinessControllerShow extends BussinessController
{
    public $address;
    public $id;

    public function execute ($request, $response, $args) {
        return $this->display($request, $response, $args);
    }

    protected function display($request, $response, $args) {
        $this->id = $args['id'];
        $this->title .= 'AddressBussiness';
        $this->address = $this->getdataAddressPoint($this->id);
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точек доступа
    protected function mainBar () {
        return $this->view->fetch('template_bussiness_show.php',
            [
                'url'                       => $this->container->router->pathFor('bussiness_pointAddress', ['bus' => $this->id, 'id' => '']),
                'address'                   => $this->address,
                'message'                   => $this->messageEmpty
            ]
        );
    }

    //Получение данных точек группированным по адресу установки точек
    protected function getdataAddressPoint ($id) {
        return $this->model->getdataAddressPoint($id);
    }
}