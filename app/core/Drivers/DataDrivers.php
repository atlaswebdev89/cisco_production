<?php

namespace Core\Drivers;

class DataDrivers {
    
    protected $model;
    protected $driverDB;
    protected $controller;

    public function __construct ($container) {
       
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
