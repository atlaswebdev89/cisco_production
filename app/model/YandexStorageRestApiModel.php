<?php

namespace Model;
use \Arhitector\Yandex\Disk;

class YandexStorageRestApiModel  {
    public $disk;
    public $shared_path = 'disk:/Отчеты';
    
    public function __construct($container) {
        $this->disk=$container->yandexDisk->getConnect(); 
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
    
    //Функция удаления ресурса
    public function deleteResource (string $path = null) {
        if(!$path) {
             throw new \MyException\ErrorYandexApi("НЕ задан путь", 404);
        }
            if($res = $this->disk->getResource($path)->delete())
                {
                    return TRUE;
                }else {
                   throw new \MyException\ErrorYandexApi("Ошибка удаления файла", 505); 
                }
    }
    
    //Функция получения (download) ресурса
    public function downloadResourse (string $path = null) {
        if(!$path) {
             throw new \MyException\ErrorYandexApi("НЕ задан путь", 404);
        }
        
        if($res = $this->disk->getResource($path)->download("php://temp"))
                {
                    return TRUE;
                }else {
                   throw new \MyException\ErrorYandexApi("Ошибка удаления файла", 505); 
                }
    }
}
