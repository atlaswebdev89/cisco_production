<?php


namespace Controller;


class ProfileUserController extends DisplayController
{
    protected $UserData;
    protected $urlRedirect = '/profileUser';

    public function execute ($request, $response, $args) {
        
        //Получение POST запроса при редактировании точки
        if ($request->isPost()) { 
            //Редактирование данных точки в БД
            if ($data = $this->editProfileData($request, $response, $args)) {
                return $response->withJson(array('url' => $this->urlRedirect, 'status' => TRUE));
            } else {
                return $response->withJson(array('url' => FALSE, 'status' => FALSE, 'message' => 'Ошибка. Попробуйте еще раз'));
            };
        }
        return $this->display($request, $response, $args);
    }

    protected function getGallery() {
        return true;
    }

    public function display($request, $response, $args)
    {
        $this->title .= "UserProfileEdit";
        $this->header = "Редактирования данных профиля";
        $this->UserData = $this->container->users->UsersDataForEdit($request, $this->session['user_id']);
        $this->page_script = $this->getScripts();

        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar () {
        return $this->view->fetch('template_profile_page.php',[
            'nameUser'                      => $this->UserData['name'],
            'secondnameUser'                => $this->UserData['secondname'],
            'phone'                         => $this->UserData['phone'],
            'JobsDepartment'                => $this->UserData['JobsDepartment'],
            'session'                       => $this->session,
            'header'                        => $this->header
            
        ]);
    }
    //Получить необходимые скрипы для отображения страницы
    protected function getScripts () {
        return [         
            '/js/bootstrap-formhelpers.min.js',
            '/js/editProfileUsers.js'
        ];
    }
    
    protected function editProfileData ($request, $response, $args) {
            //Получение POST данных из запроса
            $posts_data = $request->getParsedBody();
            //Очистка данных от всего лишнего
            foreach ($posts_data as &$data) {
                $data = $this->clear_str($data);
            }
            $posts_data['id_user'] = $this->session['user_id'];
            //Изменение данных пользователя в БД
            if ($this->model->editUserdata($posts_data)){
                 //Обновление данных сессии если были изменения в БД
                $this->container->sessionData->updatesessionDataUser($posts_data);
                return TRUE;   
            }else 
                return FALSE;  
        
    }
}


