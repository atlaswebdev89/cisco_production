<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of BussinessControllerShowPoint
 *
 * @author root
 */
class BussinessControllerShowPoint extends BussinessController{
    
    protected $page;
    protected $dataBussinessPoint;
    protected $messageEmpty;
    protected $idBus;

    //Данные для пагинации
    protected $tablename = PREF."point_data";

    public function __construct($container) {
        parent::__construct($container);
        //Объект класса пагинации
        $this->pager = $container->pager;
    }
    
    public function execute ($request, $response, $args) {
        //Номер страницы постраничной навигации
        $this->page = isset($args['page']) ? $args['page']:1;
        //id органицазии, точки которой надо получить
        $this->idBus = $args['id'];


        $this->pager->setData([
            'page'              => $this->page,
            'tablename'         => $this->tablename,
            'fields' => "`".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip, `".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
                . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`,"
                . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
                . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
                . "`".PREF."business`.`name`",
            'join' => " LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
                ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
                ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
                ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`",
            'where'             => "`".PREF."point_data`.`id_business` =" .$this->idBus."",
            'order'             => " ORDER BY `".PREF."point_data`.`installation_date` DESC",
            'post_number'       => POST_NUMBER,
            'number_link'       => NUMBER_LINKS
        ]);

        //Получение списка точек с учетом постраничной навигации
        $this->dataBussinessPoint =  $this->pager->getItems();

        //Если страница пагинации не первая и пустая выдать 404 ошибку
        if(!($this->dataBussinessPoint['items']) && $this->page != 1) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }

        //Если страница пагинации  первая и пустая выдать message
        if(!($this->dataBussinessPoint['items']) && $this->page = 1) {
            $this->messageEmpty = "Точек Cisco нет";
        }

        return $this->display($request, $response, $args);
    }
    protected function display($request, $response, $args) {

        $this->title .= 'AccessPointBussiness';

        //Формирование разрешения для отображения блоков в зависимости от роли
        $this->getBlockShowRole();

        //Подключение необходимых скриптов
        $this->page_script = $this->getScripts();

        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            '/js/point-del.js'
        ];
    }

    //Получение главного блока данных точек доступа
    protected function mainBar () {
        return $this->view->fetch('template_point_page.php',
            [
                'point'                   => $this->dataBussinessPoint['items'],
                'navigation'              => $this->dataBussinessPoint['navigation'],
                'uri'                     => '/bussiness/points/show/id/'.$this->idBus.'/page/',
                'show_block_admin'        => $this->showBlockadmin,
                'show_block_moderator'    => $this->showBlockmoderator,
                'message'                 => $this->messageEmpty
            ]
        );
    }
}
