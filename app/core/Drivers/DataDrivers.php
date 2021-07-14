<?php

namespace Core\Drivers;

class DataDrivers {
    
    protected $model;
    protected $driverDB;
    protected $controller;

    public function __construct ($container) {
        $this->driverDB = $container['driver'];
    }
    
    //Получение объекта модели для текущего контроллера (Reflection API PHP)
    public function addModelController ($controller) {
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
                    $this->model = new $class_model($this->driverDB);
                }else {
                    throw new \Exception("Not Found Class ".$class_model);
                }
    }
    
    //Посредник для выполения запросов на получение данных
    public function query($query, array $params = null, $cache = '') {
        if($cache == 'cache') {
                $key =  "KEY".md5($query.$this->controller);
                            $cash = $this->memcached->get($key);
                                if(isset($cash) && !empty($cash)){
                                    return $cash;
                                }
                        $data = $this->model->$query($params);
                   if($data) $this->memcached->set($key, $data);
                return $data;
            }
        return $this->model->$query($params);
    }
    
    //Запросы в БД без кеширования
    public function queryNoCache ($query, array $params =null) {
        return $this->model->$query($params);
    }
}
