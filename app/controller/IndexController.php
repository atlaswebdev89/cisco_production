<?php

namespace Controller;

class IndexController extends DisplayController {
    protected $count_point;
    protected $count_business;
    public function execute ($request, $response, $args) {
            return $this->display($request, $response, $args);
    }
        
    protected function getGallery() {
        return true;
//         return $this->model->getGallery();
//            return  $this->view->render($response,'foto-list.html', [  
//                                                            'gallery'       => $this->model->getGallery()
//                                                        ]);   
    }
    
    protected function display($request, $response, $args) {
            //Формирование разрешения для отображения блоков в зависимости от роли
            $this->getBlockShowRole();
            $this->title .= 'HOME';

            //Получаем количество установленных точек и количество организаций заказчиков
            $this->count_point = $this->getCountPoint();
            $this->count_business = $this->getCountBus();

            $this->mainbar = $this->mainBar();            
            parent::display($request, $response, $args);
    }
    
    public function mainBar () {
          return $this->view->fetch('template_home_page.php', 
                                                        [   
                                                            'session'               => $this->session,
                                                            'show_block_admin'      => $this->showBlockadmin,
                                                            'show_block_moderator'  => $this->showBlockmoderator,
                                                            'count_point'           => $this->count_point,
                                                            'count_business'        => $this->count_business
                                                        ]);       
    }
    //Количество точек wifi
    protected function getCountPoint() {
        $data = $this->model->getCountPoint();
        return $data[0]['count'];
    }
    //Количество организаций
    protected function getCountBus() {
        $data = $this->model->getCountBus();
        return $data[0]['count'];
    }


    public function rand () {
        echo $maxlifetime = ini_get("session.gc_maxlifetime"); "<br>";
        echo $this->model->generateSalt ();
    }
    
    
   
}
