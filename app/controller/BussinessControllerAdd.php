<?php

namespace Controller;

class BussinessControllerAdd extends BussinessController{
    protected $messageError = '';
    protected $dataBus;
    public function execute ($request, $response, $args) {
        if ($request->isPost()) {
                //Добавление данных организации в БД
                if($data = $this->addBussinessbd($request, $response, $args)) {
                    return $response->withRedirect('/bussiness/');
                }else {
                    //Защита от повторной отправки данных формы
                        $_SESSION['message_error'] = $this->messageError;
                        $_SESSION['nameBusiness'] = $this->dataBus['name'];
                        $_SESSION['busDescription'] = $this->dataBus['description'];
                        $_SESSION['placemark_color'] =$this->dataBus['color'];
                    return $response->withRedirect($uri = $request->getUri()->getpath());
                };
          }          
        return $this->display($request, $response, $args);
    }

    protected function display($request, $response, $args) {        
        $this->title .= 'NewBussiness';
        $this->page_script = $this->getScripts();
        $this->mainbar = $this->mainBar();
        $this->deleSessionBus();
        parent::display($request, $response, $args);
    }
    
     //Получение главного блока данных точек доступа
    protected function mainBar () {
        $messageError =             (isset($this->session['message_error']))?$this->session['message_error']:'';
        $name =                     (isset($this->session['nameBusiness'])) ? $this->session['nameBusiness'] : '';
        $description =              (isset($this->session['busDescription']))? $this->session['busDescription']:'';
        $placemark_color =          (isset($this->session['placemark_color']))?$this->session['placemark_color']:'';

        return $this->view->fetch('template_bussiness_add.php',
            [
                'message_error' => $messageError,
                'name' => $name,
                'description' => $description,
                'placemark_color' => $placemark_color
            ]
        );
    }
    
    protected function addBussinessbd($request, $response, $args) {
         $posts_data = $request->getParsedBody();
         $this->dataBus = $posts_data;
            //Очистка данных от всего лишнего
            foreach ($posts_data as &$data) {                
                $data = $this->clear_str($data);
            }
            //Проверка есть ли данная организация в БД
            if($bus = $this->model->getBusines($posts_data['name'])){
                    $this->messageError = "Такая организация есть в БД";
                return FALSE;
            }
            //Запрос в модель на добавление новой организации в БД
            if($idBuss = $this->model->addBus($posts_data)){
                 return $idBuss;
            }else {
                $this->messageError = "Ошибка добавления. Попробуйте ещё раз";
                return FALSE;
            }           
    }

    protected function getScripts()
    {
        return [
            '/js/jscolor.js'
        ];
    }

    protected function deleSessionBus () {
        unset($_SESSION['message_error']);
        unset($_SESSION['nameBusiness']);
        unset($_SESSION['busDescription']);
        unset($_SESSION['placemark_color']);
    }
}
