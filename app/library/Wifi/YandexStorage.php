<?php

namespace Wifi;
use \Arhitector\Yandex\Disk;

class YandexStorage {
  
    public $disk;
    public $shared_path = 'disk:/Отчеты';
    
    public function __construct($container) {
        $this->createConnect();
    }
    
    //Создание объекта для работы с api Yandex Disk 
    //Токен JWT можно передать сразу в конструкторе
    protected function createConnect ($token = 'AQAAAABAhrrGAAdD66Oq0PGZhEsjriIcdHbebeU') {
        $this->disk = new Disk($token);
    }
    
    //Добавление токена 
    public function setToken ($token) {
        $this->disk->setAccessToken($token);
    }
    
    //Получение объекта для работы с API
    public function getConnect () {
        return $this->disk;
    }
    
    //Функция получения списка отчетов на странице отчеты
    public function getResource (string $path = null) {
        if (!isset ($path) && empty($path)) {
            $path = $this->shared_path;
        }
        
        $listDisk = [];
        $resource = $this->disk->getResource($path)->toObject(['name', 'items']);
                        foreach ($resource->items as $item) {
                                $td = explode('T', $item->modified);
                                $date = $td[0];
                                $time = date('H:i:s',(strtotime(substr($td[1],0,8))+(60*60*3)));
                              $item = $item->toObject();
                                    $listDisk [] = [
                                            'name' => trim($item->name),
                                            'date' => $date,
                                            'time' => $time,
                                            'type' => $item->type,
                                            'path' => $item->path,
                                            'resourse_id' => md5($item->resource_id),
                                    ];
                            } 
                return $listDisk;
    }
    
    public function getResourceObj ($path) {
        return $this->disk->getResource($path);
    }
   
}
