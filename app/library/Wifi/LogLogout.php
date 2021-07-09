<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wifi;

/**
 * Description of LogLogout
 *
 * @author atlas
 */
class LogLogout implements \Interfaces\Observer {
    protected $model;
    
    public function __construct($model) {
        $this->model=$model;
    }

    public function update(\Interfaces\Observable $subject) {        
        $this->model->updateLogUsersLogout($_SESSION['sess']);
    }
}
