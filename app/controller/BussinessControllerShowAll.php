<?php


namespace Controller;


class BussinessControllerShowAll extends BussinessController
{

    protected $page;
    protected $dataBussiness;
    protected $messageEmpty;
    

    //Данные для пагинации
    protected $tablename = PREF."business";

    public function __construct($container) {
        parent::__construct($container);
        //Объект класса пагинации
        $this->pager = $container->pager;
    }

    public function execute ($request, $response, $args) {
        //Номер страницы постраничной навигации
        $this->page = isset($args['id']) ? $args['id']:1;

        $this->pager->setData([
            'page'              => $this->page,
            'tablename'         => $this->tablename,
            'fields'            => " *, (SELECT COUNT(*) FROM `".PREF."point_data` WHERE `".PREF."point_data`.`id_business` = `".PREF."business`.`id`) as point",
            'join'              => FALSE,
            'where'             => FALSE,
            'order'             => " ORDER BY `point` DESC, name ASC",
            'post_number'       => POST_NUMBER,
            'number_link'       => NUMBER_LINKS
        ]);

        //Получение списка точек с учетом постраничной навигации
        $this->dataBussiness =  $this->pager->getItems();

        //Если страница пагинации не первая и пустая выдать 404 ошибку
        if(!($this->dataBussiness['items']) && $this->page != 1) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }

        //Если страница пагинации  первая и пустая выдать message
        if(!($this->dataBussiness['items']) && $this->page = 1) {
            $this->messageEmpty = "Организаций нет в базе";
        }

        return $this->display($request, $response, $args);
    }

    protected function display($request, $response, $args) {
        $this->title .= 'Bussiness';

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
            '/js/bussiness-del.js'
        ];
    }

    //Получение главного блока данных точек доступа
    protected function mainBar () {
        return $this->view->fetch('template_bussiness_showAll.php',
            [
                'bussiness'               => $this->dataBussiness['items'],
                'navigation'              => $this->dataBussiness['navigation'],               
                'uri'                     => '/bussiness/page/',
                'add'                     => '/bussiness/add/',  
                'show_block_admin'        => $this->showBlockadmin,
                'show_block_moderator'    => $this->showBlockmoderator,
                'message'                 => $this->messageEmpty
            ]
        );
    }
}