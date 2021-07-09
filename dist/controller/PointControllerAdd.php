<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of PointControllerAdd
 *
 * @author atlas
 */
class PointControllerAdd extends PointController {
    
     //protected $urlPointShow = '/point/show/id/';
     
    
     public function execute ($request, $response, $args) {
         if ($request->isPost()) {
                //Добавление данных точки в БД
                if($data = $this->addpointbd($request, $response, $args)) {
                    return $response->withJson(array('url' => $this->urlPointShow.$data, 'status'=> TRUE));
                }else {
                    return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => 'Ошибка. Попробуйте еще раз'));
                };
          } 
          return $this->display($request, $response, $args);
    }
    protected function display($request, $response, $args) {
            $this->title .= "NewPoint";
            $this->page_script = $this->getScripts();
            $this->page_style = $this->getStyles();
            $this->mainbar = $this->mainBar();
            parent::display($request, $response, $args);
    }

//Получить необходимые стили для отображения страницы
    protected function getStyles()
    {
        return [
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css'
        ];
    }
    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js',
            '/js/jquery.ipmask.js',
            '/js/jquery.maskedinput.min.js',
            'https://api-maps.yandex.ru/2.1/?apikey=e47ca267-409d-4f76-b09a-2c71c39d6c14&lang=ru_RU',
            '/js/maps.js',
            '/js/addpoint.js'
        ];
    }

    //Получение главного блока данных точек доступа
    protected function mainBar () {
          return $this->view->fetch('template_point_add_page.php',
                                    [   
                                        'address'               => $this->getAddressForSelect(),
                                        'business'              => $this->getBusinessForSelect(),
                                        'models'                => $this->getModelCiscoForSelect(),
                                        'ssid'                  => $this->getSsidForSelect(),
                                        'speed'                 => $this->getSpeedForSelect(),
                                        'date'                  => $this->getDateCurrent()
                                    ]);       
    } 
    
    protected function getAddressForSelect () {
        return $this->model->getAddressForSelect();
    }
    
    protected function getBusinessForSelect () {
        return $this->model->getBusinessForSelect();
    }
    
    protected function getModelCiscoForSelect () {
        return $this->model->getModelCiscoForSelect();
    }
    
    protected function getSsidForSelect () {
        return $this->model->getSsidForSelect();
    }
    
    protected function getSpeedForSelect () {
        return $this->model->getSpeedForSelect();
    }

    protected function getDateCurrent () {
        $a = date("Y-m-d");

        return $a;
    }

    protected function addpointbd($request, $response, $args) {
         $posts_data = $request->getParsedBody();
            
            //Очистка данных от всего лишнего
            foreach ($posts_data as &$data) {
                
                $data = $this->clear_str($data);
            }

            //Проверка типов (метод родительского класса)
            $posts_data = $this->CheckTypeGetId($posts_data);
            //Формирование массива
            $data = $this->getdatainBd($posts_data);
          
            //Добавление данных точки в БД 
            $idData = $this->model->adddatapointBd($data);
            return $idData;
            
    }

}
