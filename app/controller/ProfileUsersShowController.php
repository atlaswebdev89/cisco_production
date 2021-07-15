<?php

namespace Controller;

class ProfileUsersShowController extends ProfileUserController {
    
    protected $UserData;
    
    public function __construct($container) { 
        parent::__construct($container);
        $this->container = $container;
        $this->routerHome = $this->container->router->pathFor('home');
        $this->profileUser = $this->container->router->pathFor('profile_user');
        $this->profileUserPass = $this->container->router->pathFor('profileUserPass');
       
    }
    
    public function execute ($request, $response, $args) {
        return $this->display($request, $response, $args);
    }

    protected function getGallery() {
        return true;
    }

    public function display($request, $response, $args)
    {
        $this->title .= "UserProfile";
        $this->header = "Данные профиля пользователя";
        $this->UserData = $this->container->users->UsersDataForEdit($request, $this->session['user_id']);    
        $this->mainbar = $this->mainBar();
        parent::display($request, $response, $args);
    }

    //Получение главного блока данных точки доступа
    protected function mainBar () {
        return $this->view->fetch('template_user_profile_page.php',[
            'nameUser'                      => $this->UserData['name'],
            'secondnameUser'                => $this->UserData['secondname'],
            'phone'                         => $this->UserData['phone'],
            'JobsDepartment'                => $this->UserData['JobsDepartment'],
            'session'                       => $this->session,
            'header'                        => $this->header,           
            'routerHome'                    => $this->routerHome,
            'profileUser'                   => $this->profileUser,
            'profileUserPass'               => $this->profileUserPass,
        ]);
    }
}
