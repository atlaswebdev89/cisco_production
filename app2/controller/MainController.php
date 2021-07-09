<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;


abstract class MainController {
    
    protected $model;
    protected $view;
    protected $container;
    protected $uri;
    protected $title;
    protected $menu;


    public function __construct($container) { 
            $this->container = $container;
            $this->model = $container->model;
            $this->view=$container->view;   
            $this->uri = $this->getUri();   
    }

    //Функция получения URL текущей страницы 
    public function getUri () { 
        $env = $this->container->environment;
            if (isset($env['REQUEST_SCHEME']) && $env['REQUEST_SCHEME'] == 'https') {
                    $https = 's://';
                }else 
                    {
                        $https='://';
                    }
         
            if (!empty($env['HTTP_HOST'])){
                    $theUri = 'http'.$https.$env['HTTP_HOST'];
            }
            if (!empty ($env['REQUEST_URI'])) {
                    $theUri.=$env['REQUEST_URI'];
            }
          
//            $theUri.='/';
            $theUri = str_replace(array("'", '"', '<','>'), array("%27", "%22", "%3C". "%3E"), $theUri);
        return $theUri;
    }
    
    public function clear_str($str) {
        $str =  strip_tags(trim($str));
        return ($str);
    }

    //Должны быть переопределены в дочерних классах
    abstract protected function execute ($request, $response, $args);
    abstract protected function display ($request, $response, $args);
    
    abstract protected function getMenu();
    abstract protected function getSidebar();
    abstract protected function getGallery ();
    abstract protected function getFooter();

    
}
