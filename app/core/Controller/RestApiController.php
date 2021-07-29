<?php

namespace Core\Controller;

class RestApiController {
    
    public $container;
    public function __construct($container) { 
            $this->container = $container;
    }
    //Получение объекта модели для текущего контроллера (Reflection API PHP)
    public function addRestModelController ($controller) {
                if(isset($controller) && !empty($controller)) {
                    $this->controller = $controller;
                }else {
                    throw new \Exception("Not set Controller");
                }
                
                $a = (new \ReflectionClass($controller));
                $name_controller = str_replace('Controller', '', $a->getShortName());
                $class_model = "\Model\\".$name_controller."Model";
                
                if($this->model instanceof $class_model){
                    return $this->model;
                }
                
                if(class_exists($class_model)){
                    return $this->model = new $class_model($this->container);
                }else {
                    throw new \Exception("Not Found Class ".$class_model);
                }
    }
}
