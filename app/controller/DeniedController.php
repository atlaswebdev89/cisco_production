<?php


namespace Controller;
use \Core\Controller\DisplayController;

class DeniedController extends DisplayController
{
    public function execute ($request, $response, $args) {
        return $this->display($request, $response, $args);
    }

    protected function getGallery() {
        return true;
    }

    protected function display($request, $response, $args) {
        $this->title .= 'Denied';
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    public function mainBar () {
        return $this->view->fetch('template_denied_page.php');
    }

}