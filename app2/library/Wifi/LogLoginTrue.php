<?php

namespace Wifi;

class LogLoginTrue implements \Interfaces\Observer{
    
    protected $model;
    public function __construct($model) {
        $this->model = $model;
    }

    public function update(\Interfaces\Observable $subject) {  
        $this->model->updateAuthLog($subject->getDataUsers());
    }
}
