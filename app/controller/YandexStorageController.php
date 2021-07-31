<?php

namespace Controller;
use Core\Controller\DisplayController;

use Arhitector\Yandex\Client\Exception\NotFoundException;
use Arhitector\Yandex\Client\Exception\UnauthorizedException;

class YandexStorageController extends DisplayController{
    
    public $yandexDisk;
    
    public function __construct($container) {
       parent::__construct($container);
           // $this->model=$this->addModelController(__CLASS__);
            $this->yandexDisk = $container->yandexDisk; 
    }
    
    public function execute ($request, $response, $args) {
        return $this->display($request, $response, $args);
    }
    
    protected function getGallery() {
        return true;
    }
    
    protected function display($request, $response, $args) {
        
            $this->yandexList = $this->api_ya_get_files();
            //Формирование разрешения для отображения блоков в зависимости от роли
            $this->getBlockShowRole();
            $this->mainbar = $this->mainBar();
            parent::display($request, $response, $args);
    }
    
    protected function api_ya_get_files ($path =null) {
        
            try {   
                    return $resource = $this->yandexDisk->getResource($path);
            }
            catch(UnauthorizedException $exc) {
                echo  $exc->getMessage(); exit;
            }

            catch (NotFoundException $exc) {
                echo $exc->getMessage() ." ". $exc->getCode(); exit();
            }
    }


    protected function mainBar () {
        return $this->view->fetch('template_storage_yandex.php',[
                                            'show_block_admin'      => $this->showBlockadmin,
                                            'show_block_moderator'  => $this->showBlockmoderator,
                                            'listDisk'              => $this->yandexList,
                                        ]);       
    }
}
