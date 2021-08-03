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
    
    //Функция для скачивания 
    public function downloadFiles ($filepath) {
        
    // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
    // если этого не сделать файл будет читаться в память полностью!
    if (ob_get_level()) {
      ob_end_clean();
    }
    // заставляем браузер показать окно сохранения файла
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=new.xls');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: ' . filesize($filepath));
    // читаем файл и отправляем его пользователю
    rewind($filepath);
            echo stream_get_contents($filepath);
      fclose($filepath);
        
    }
}
