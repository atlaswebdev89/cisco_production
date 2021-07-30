<?php

namespace Controller;
use \Core\Controller\DisplayController;

use Arhitector\Yandex\Client\Exception\NotFoundException;
use Arhitector\Yandex\Client\Exception\UnauthorizedException;

class ReportsController extends DisplayController
{
    protected $report;
    protected $path = 'disk:/Отчеты/Показатели качества сети CIscoWifi/';
    
    public function __construct($container) {
        $this->container = $container;
        $this->report = $container->reports;
        $this->yandex = $container->yandexDisk;
    }

    public function csv ($request, $response, $args){
        return $this->report->getCsv($request, $response, $args);
    }

    
    //переделать под асинхронные запросы
    public function execute ($request, $response, $args) {
            //Формируем отчет и помещаем его во временную папку
            $file_report =  $this->report->getExcel($request, $response, $args);
            //Проверяем если ли папка для отчетов в текущем месяце Если нет создаем ее       
            $dir =  $this->yandex->getResourceObj($this->path.date('Y-m').'/');
                if(!$dir->has()) { 
                        $dir->create();
                }
            //Загружаем сформированный отчет в хранилище YandexDisk
            $resourse = $this->yandex->getResourceObj($this->path.date('Y-m').'/'.date('H-m-s').'.xls')->upload($file_report, true); 
                //Удаляем файл 
                unlink($file_report);
            return $response->withRedirect($this->container->router->pathFor('home'));


        exit;



        $array = array(
            '1' => '123 1',
            '2' => 'faf 2',
            '3' => 'fawfawf 3',
            '4' => 'fawfaf 4',
            '5' => '`1bnac` 5'
        );

        $json = json_encode($array);
        print_r ($array);
        return $response
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Accept-Ranges', 'bytes')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Pragma', 'public')
            //->withHeader('Content-Length', '1215152')
            ->withHeader('Content-Disposition', 'attachment; filename=json');


        exit;

        $file  = $_SERVER['DOCUMENT_ROOT'].'/download/3.jpg';

        if (file_exists($file)) {
                readfile($file);
                return $response
                    ->withHeader('Content-Description', 'File Transfer')
                    ->withHeader('Content-Type', 'application/octet-stream')
                    ->withHeader('Accept-Ranges', 'bytes')
                    ->withHeader('Content-Transfer-Encoding', 'binary')
                    ->withHeader('Expires', '0')
                    ->withHeader('Cache-Control', 'must-revalidate')
                    ->withHeader('Pragma', 'public')
                    ->withHeader('Content-Length', filesize($file))
                    ->withHeader('Content-Disposition', 'attachment; filename=12.jpg');
        }
    }

    protected function display($request, $response, $args) {
        parent::display($request, $response, $args);
    }
    protected function getGallery() {
        return true;
    }
}