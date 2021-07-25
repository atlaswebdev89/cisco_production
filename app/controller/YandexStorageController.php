<?php

namespace Controller;
use Core\Controller\DisplayController;

use Arhitector\Yandex\Client\Exception\NotFoundException;
use Arhitector\Yandex\Client\Exception\UnauthorizedException;

class YandexStorageController extends DisplayController{
    
    public $disk;
    
    public function __construct($container) {
       parent::__construct($container);
            $this->model=$this->addModelController(__CLASS__);
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
            //Подключение необходимых скриптов
            $this->page_script = $this->getScripts();
            //Формирование разрешения для отображения блоков в зависимости от роли
            $this->getBlockShowRole();
            $this->mainbar = $this->mainBar();
            parent::display($request, $response, $args);
    }
    
    protected function api_ya_get_files ($path =null) {
        
            try {   
                        //Получаем токен и передаем клиенту (объекту) для работы с yandex disk
                        $this->yandexDisk->setToken('AQAAAABAhrrGAAdD66Oq0PGZhEsjriIcdHbebeU');
                    return $resource = $this->yandexDisk->getResource($path);
            }
            catch(UnauthorizedException $exc) {
                echo  $exc->getMessage(); exit;
            }

            catch (NotFoundException $exc) {
                echo $exc->getMessage() ." ". $exc->getCode();
            }
    }


    protected function mainBar () {
        return $this->view->fetch('template_storage_yandex.php',[
                                            'show_block_admin'      => $this->showBlockadmin,
                                            'show_block_moderator'  => $this->showBlockmoderator,
                                            'listDisk'              => $this->yandexList,
                                        ]);       
    }
    
    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            '/js/getResourseDisk.js'
        ];
    }
    
    public function getResourseAjax ($request, $response, $args) {
        if ($request->isPost()) {
            $posts_data = $request->getParsedBody();
                $resource = $this->api_ya_get_files($posts_data['path']);
                
                if (is_array($resource) && !empty($resource)) {
                        $data = [
                           'status' => true,
                           'data' => $resource
                       ];
                    return json_encode($data);
                }elseif(empty ($resource)){
                    $data = [
                           'status' => false,
                           'data' => $resource
                       ];
                    return json_encode($data);
                }
                
        }
    }
}