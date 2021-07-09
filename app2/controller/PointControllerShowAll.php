<?php

namespace Controller;

class PointControllerShowAll extends PointController
{
    protected $page;
    protected $dataPoint;
    protected $messageEmpty;

    //Данные для пагинации
    protected $tablename = PREF."point_data";

    public function __construct($container) {
        parent::__construct($container);
        //Объект класса пагинации
        $this->pager = $container->pager;
    }

    public function execute ($request, $response, $args) {

        //Номер страницы постраничной навигации
        $this->page = isset($args['id']) ? $args['id']:1;

        $this->pager->setData([
            'page' => $this->page,
            'tablename' => $this->tablename,
            'fields' => "`".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip, `".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
                . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`,"
                . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
                . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
                . "`".PREF."business`.`name`",
            'join' => " LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
                ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
                ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
                ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`",
            'order' => "ORDER BY `id` DESC",
            'where' => FALSE,
            'post_number' => POST_NUMBER,
            'number_link' => NUMBER_LINKS
        ]);

        //Получение списка точек с учетом постраничной навигации
        $this->dataPoint =  $this->pager->getItems();

        //Если страница пагинации не первая и пустая выдать 404 ошибку
        if(!($this->dataPoint['items']) && $this->page != 1) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }

        //Если страница пагинации  первая и пустая выдать message
        if(!($this->dataPoint['items']) && $this->page = 1) {
                $this->messageEmpty = "Точек нет в Базе Данных";
        }

        return $this->display($request, $response, $args);
    }
    protected function display($request, $response, $args) {

        $this->title .= 'AccessPoint';

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
                'point'                   => $this->dataPoint['items'],
                'navigation'              => $this->dataPoint['navigation'],
                'uri'                     => '/point/page/',
                'show_block_admin'        => $this->showBlockadmin,
                'show_block_moderator'    => $this->showBlockmoderator,
                'message'                 => $this->messageEmpty
            ]
        );
    }

}