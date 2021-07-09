<?php


namespace Wifi;

class Cookie extends \Slim\Http\Cookies {
    public function __construct(array $cookies = array()) {
        parent::__construct($cookies);
    }
}
