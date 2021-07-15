<?php


namespace Controller;
use \Core\Controller\DisplayController;

class BussinessController extends DisplayController
{
    protected $pager;
    
    public function __construct($container) {
       parent::__construct($container);
        $this->model=$this->addModelController(__CLASS__);
    }

    public function execute ($request, $response, $args) {
        return $this->display($request, $response, $args);
    }
    protected function display($request, $response, $args) {
        parent::display($request, $response, $args);
    }
    protected function getGallery() {
        return true;
    }
}