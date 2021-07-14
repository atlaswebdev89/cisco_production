<?php


namespace Controller;
use \Core\Controller\DisplayController;

class BussinessController extends DisplayController
{
    protected $pager;


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