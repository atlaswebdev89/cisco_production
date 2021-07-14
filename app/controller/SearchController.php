<?php


namespace Controller;
use \Core\Controller\DisplayController;

class SearchController extends DisplayController
{
    protected $page;
    protected $dataRequest = 0;
    protected $messageEmpty;
    protected $template;
    protected $temp;
    protected $dataNameOrganizations;
    protected $pager;
    protected $getParams;

    public function __construct($container) {
        parent::__construct($container);
        //Объект класса пагинации
        $this->pager = $container->pager;
    }

    public function execute ($request, $response, $args) {
        //Защита от повторной отправки данных формы при обновлении страницы (при получении данных делаем редирект на страницу поиска)
            //Получение POST запроса при поиске точки
//            if ($request->isPost()) {
//                //Получение строки введенной в поиск пользователем
//                    $posts_data = $request->getParsedBody();
//                    $_SESSION['requestDataSearch'] = $posts_data['searchRequest'];
//                return $response->withRedirect($uri = $request->getUri()->getpath());
//            }
//
//            if ($this->session['requestDataSearch']) {
//                if ($result = $this->searchDatainBD($this->session['requestDataSearch'])) {
//                    $this->dataRequest = $result;
//                }
//            }
//            
            $this->page = isset($args['id']) ? $args['id']:1;
            
            //Поиск через метод GET
            if($post_data = $request->getQueryParams()) { 
                //Строка запроса для формирования правильных url  при переходе на страницы пагинации
                $this->getParams = '/?searchRequest='.$post_data['searchRequest'];
                if ($result = $this->searchDatainBD($post_data['searchRequest'])) {
                        $this->dataRequest = $result;
                        //Получение необходимо шаблона для вывода результатов
                                if ($this->temp) {
                                    $this->getTemplateSearch($this->temp);
                                }                     
                }else {
                    $this->template = 'template_search_page.php';
                        }

        }   else {
                $this->template = 'template_search_page.php';
            }
            
            if($this->dataRequest){
                $this->pager->setDataArray (
                        [
                            'data'              => $this->dataRequest,
                            'page'              => $this->page,
                            'post_number'       => POST_NUMBER,
                            'number_link'       => NUMBER_LINKS
                        ]);
               //Получение результатов поиска с учетом пагинации
               $this->dataRequest = $this->pager->getItemsArrayData ();
              
            }
            
            //Если страница пагинации не первая и пустая выдать 404 ошибку
            if(!($this->dataRequest['items']) && $this->page != 1) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            return $this->display($request, $response, $args);
    }
    
    protected function display($request, $response, $args) {
        //Формирование разрешения для отображения блоков в зависимости от роли
        $this->getBlockShowRole();
        //Подключение необходимых скриптов
        $this->page_script = $this->getScripts();
        $this->title .= "Search";      
        $this->mainbar = $this->mainBar($this->template);
        parent::display($request, $response, $args);
    }
    protected function getGallery() {
        return true;

    }

    //Получение главного блока данных точек доступа
    protected function mainBar ($template) {
        return $this->view->fetch($template,
                [
                        'point'                     => $this->dataRequest['items'],
                        'navigation'                => $this->dataRequest['navigation'],
                        'getRequest'                => $this->getParams,
                        'uri'                       => '/search/page/',
                        'show_block_admin'          => $this->showBlockadmin,
                        'show_block_moderator'      => $this->showBlockmoderator,
                        'message'                   => $this->messageEmpty
                ]);
    }

    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [
            '/js/point-del.js',
            '/js/bussiness-del.js'
        ];
    }
    
    protected function getTemplateSearch ($template) {
                    switch ($template) {
                        case 'ip':
                            $this->template = 'template_search_page.php';
                            break;
                        case 'firma':
                            $this->template = 'template_search_businness_page.php';
                            break;
                        case 'ssid':
                            $this->template = 'template_search_ssid_page.php';
                            break;
                    }
    }

    protected function searchDatainBD ($data) {       
        $request = $this->clear_str($data);
        $array = array();      
        //Получаем все точки в бд
        $DataReturn = $this->model->searchDataPoint();
        
        //Проверяем совпадения строки запроса с полем ip 
        foreach ($DataReturn as $item) {
            if (stripos($item['ip'], $request) !== FALSE) {
                $array[] = $item;
            }
        }

        //Проверяем полученные данные
        if ($array) {
            $this->temp = 'ip';
            return $array;
        }else {

            //Проверяем совпадения строки запроса с полем ssid (Название сети wifi)
            foreach ($DataReturn as $item) {
                if (mb_stripos ($item['ssid'], $request) !== FALSE) {
                    $array[] = $item;
                }
            }
        }
        if ($array) {
            $this->temp = 'ssid';
            return $array;
        }else {
            //Проверяем совпадения строки запроса с полем name (Название организации)
            $this->dataNameOrganizations=$this->model->getOrganizations();
            foreach ($this->dataNameOrganizations as $item) {
                if (mb_stripos($item['name'], $request) !== FALSE){
                    $array[] = $item;
                }
            }
        }
        if ($array) {
            $this->temp = 'firma';
            return $array;
        } else {
            $this->messageEmpty = "Нет совпадения";      
        }       
    }
}