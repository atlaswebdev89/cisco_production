<?php

namespace Controller;

class ProfileUserControllerPass extends ProfileUserController
{
    protected $urlRedirect = '/profileUser';
    public function execute ($request, $response, $args) {
        //Получение POST запроса при редактировании точки
        if ($request->isPost()) { 
            //Изменение пароля пользователя
            return  $this->ChangeUserPass($request, $response, $args);
        }
        return $this->display($request, $response, $args);
    }

    protected function getGallery() {
        return true;
    }

    public function display($request, $response, $args)
    {
        $this->title .= "ChangePassUser";
        $this->header = "Смена пароля";
        $this->UserData = $this->container->users->UsersDataForEdit($request, $this->session['user_id']);
        //print_r($this->UserData); print_r($this->session); exit;
        $this->page_script = $this->getScripts();
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar () {
        return $this->view->fetch('template_profile_pass_page.php',[
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
            '/js/changePassUser.js'
        ];
    }
    
    protected function ChangeUserPass ($request, $response, $args) {
        //Получение POST данных из запроса
            $posts_data = $request->getParsedBody();
            //Очистка данных от всего лишнего
            foreach ($posts_data as &$data) {
                $data = $this->clear_str($data);
            }
            
           //Проверяем пароль пользавателя
           $data = $this->container->users->getDataAuthUser($this->session['user_id']);
           $passwordUser = $data[0]['password'];
           //Проверка совпадения пароля в БД и пароля введенного в форму (текущий пароль)
           if ($passwordUser != md5($posts_data['oldpass'])) 
               {
               return $response->withJson(array('url' => FALSE, 'status' => FALSE, 'message' => 'Указан не верный текущий пароль пользователя'));
           }else if ($posts_data['newpass'] == $posts_data['newpassRep']){
               $change = $this->container->users->changePassUser($this->session['user_id'], md5($posts_data['newpass']));
           }
            
           if ($change){        
                 return $response->withJson(array('status' => TRUE));
               } else {
                   return $response->withJson(array('url' => FALSE, 'status' => FALSE, 'message' => 'Ошибка. Попробуйте еще раз'));
               }
           
             
    }
    
}

