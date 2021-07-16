<?php

namespace Core\Extensions;

class Timer {
    
    private  $start = 0;
    
    protected function __construct() {
        
    }
    
    protected function start () {
        $this->start = microtime(true);
    }
    
    public function finish()
    {
            if(!$this->start == 0) {
                return round((microtime(true) - $this->start), 4);
            }
        return 0;
    }
    
    //Статический метод для создания объектов класса и вызова соответствующего метода
    static public function getInstanse($method) {
            $object = new self();
                //Проверка наличия метода 
                if(method_exists($object, $method)) {
                    $object->$method();
                }else {
                    throw new \Exception("Not Found Method Class (".__CLASS__.")");
                }
        return $object;
    }
    
}