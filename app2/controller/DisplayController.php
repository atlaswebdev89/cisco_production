<?php

namespace Controller;

abstract  class DisplayController extends MainController {
    
    protected $mainbar;

    //Переменые для подключение дополнительных стилей в зависимости от вида
    protected $page_style = array();
    protected $page_script = array();

    //Разрешение отображение определенных блоков
    public $showBlockadmin = FALSE;
    public $showBlockmoderator = FALSE;

    public function __construct($container) { 
            parent::__construct($container);
            $this->title = 'WifiCisco | ';
            $this->header = 'Введите ваши учетные данные для входа в систему';
            $this->session = $_SESSION;
            $this->countUser = 0;
    }
   
   //Получить меню Отображение в зависимости от роли пользователя
    protected function getMenu() {
        $array = array();
        //Получение элментов меню из БД
        $data = $this->model->getMenu();
        //Формирование массима элементов меню, значения id которых указаны в данных сессии.
        foreach ($this->session['menu'] as $items){
             foreach ($data as $item) {
                 if ($item['id'] == $items) {
                        $array[$item['position']] = $item;
                        continue;
                }       
            } 
       }

        //Сортировка массива по позициям. Позиции указаны к бд и используются к качестве ключей для значений массива
        ksort($array);
       foreach ($array as &$item) {
           $item['alias'] = $this->routerLogin = $this->container->router->pathFor($item['alias']);
       }
       return $array;
 }
    //Получение необходимых разрешений в зависимости от роли для отображения определенных блоков
    public function getBlockShowRole () {
        if($this->session['role_alias']){
            $ret = $this->container->viewsblockrole->getShowBlock($this->session['role_alias']);
                $this->showBlockadmin           =       $ret['show_block_admin'];
                $this->showBlockmoderator       =       $ret['show_block_moderator'];
        };
    }

    protected function getSidebar() {}
            
    protected function getCount () {
        return $this->model->getCountDB();
    }
    
    protected function usersOnline () { 
        return $this->model->getUsersOnline();
    }
            
    protected function getFooter () {}

    protected function display($request, $response, $args) {
       
            $this->view->render($response, 'index.php', [   
                                                            'container'     => $this->container->router,
                                                            'title'         => $this->title,
                                                            'page_style'    => $this->page_style,
                                                            'page_script'   => $this->page_script,
                                                            'menu'          => $this->getMenu(),
                                                            'uri'           => $this->uri,
                                                            'mainbar'       => $this->mainbar,           
                                                            'session'       => $this->session, 
                                                            'userOnline'    => $this->usersOnline(),
                                                            'countDB'       => $this->getCount(), 
                                                            'timePage'      => \Wifi\TimePage::finish_time()
                                                        ]);   
        } 
        
    protected function display_login ($request, $response, $args) {
        $this->view->render($response, 'pagelogin.php', [   
                                                            'title'         => $this->title,
                                                            'header'        => $this->header,
                                                            'mainbar'       => $this->mainbar           
                                                        ]);   
    }
}
