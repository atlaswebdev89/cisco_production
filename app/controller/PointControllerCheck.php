<?php

namespace Controller;

class PointControllerCheck extends PointController{
   
    public function execute ($request, $response, $args) {
        if ($request->isPost()) {
                $posts_data = $request->getParsedBody();
                if (isset($posts_data['ip']) && !empty ($posts_data['ip'])) {
                    $ip = ip2long($posts_data['ip']);
                } 
               $status = $this->checkIpPoint($ip);
                if ($status > 0) {
                    return $response->withJson(array('status'=> FALSE));   
            }
          }
          
    }
    
    protected function checkIpPoint ($ip) {
        return $this->model->checkIpPoint($ip);
    }
    
}
