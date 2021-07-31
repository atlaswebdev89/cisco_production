<?php

namespace Controller;
use Core\Controller\RestApiController;
use Arhitector\Yandex\Client\Exception\NotFoundException;
use Arhitector\Yandex\Client\Exception\UnauthorizedException;

class YandexStorageRestApi extends RestApiController {
  
    public $model;
    
    public function __construct($container) {
       parent::__construct($container);
            $this->model=$this->addRestModelController(__CLASS__);
    }
    
    protected function api_request ($method,  $params) {
        
            try {   
                    return $resource = $this->model->$method($params);
            }
            catch (UnauthorizedException $exc) {
                    echo  $this->sendData(['status' => 'error', 'data' => ['code'=>$exc->getCode(), 'message'=> $exc->getMessage()]]);
                die();
            }

            catch (NotFoundException $exc) {
                    echo  $this->sendData(['status' => 'error', 'data' => ['code'=>$exc->getCode(), 'message'=> $exc->getMessage()]]);
                die();
            }
            catch (\MyException\ErrorYandexApi $exc) {
                    echo  $this->sendData(['status' => 'error', 'data' => ['code'=>$exc->getCode(), 'message'=> $exc->getMessage()]]);
                die();
            }
            
    }
    
    public function getResourse ($request, $response, $args) {
        if ($request->isPost()) {
            $posts_data = $request->getParsedBody();
                $resource = $this->api_request('getResource', $posts_data['path']);
                if (is_array($resource) && !empty($resource)) {
                    return $this->sendData(['status' => true,'data' => $resource]);
                }elseif(empty ($resource)){
                    return $this->sendData(['status' => 'empty','data' => $resource]);
                }
        }
    }
    
    public function deleteResourse ($request, $response, $args) {
       if ($request->isPost()) {
            $posts_data = $request->getParsedBody();
                if($this->api_request('deleteResource', $posts_data['path'])){
                    return $this->sendData(['status' => true]);
                };
       }
    }
    
    //Функция download ресурса
    public function downloadResourse ($request, $response, $args) {
        if ($request->isPost()) {
            $posts_data = $request->getParsedBody();
                if($this->api_request('downloadResourse', $posts_data['path'])){
                    return $this->sendData(['status' => true]);
                };
       }
    }
    
    //Функция отправки данных
    public function sendData (array $arr) {
        return json_encode($arr);
    }
}
