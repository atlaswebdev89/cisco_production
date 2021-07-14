<?php


namespace Controller;
use \Core\Controller\DisplayController;

class ReportsController extends DisplayController
{
    protected $report;
    public function __construct($container) {
        $this->report = $container->reports;
    }

    public function csv ($request, $response, $args){
        return $this->report->getCsv($request, $response, $args);
    }

    public function execute ($request, $response, $args) {

        return $this->report->getExcel($request, $response, $args);



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