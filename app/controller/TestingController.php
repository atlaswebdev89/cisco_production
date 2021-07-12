<?php

namespace Controller;

class TestingController extends DisplayController {
    
    public function __construct($container) {
       parent::__construct($container);
            $this->clientData->addModelController(__CLASS__);
    }
    
    public function execute ($request, $response, $args) {
        echo 123;exit;
    }
    
    public function execute2 () {
        echo 123;exit;
    }

    protected function getGallery() {
        return true;
    }
}
