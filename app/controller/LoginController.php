<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;
use \Core\Controller\DisplayController;
/**
 * Description of LoginController
 *
 * @author atlas
 */
class LoginController extends DisplayController implements \Interfaces\Observable{
    
    
    protected $container;
    protected $userId;
    protected $dataUsers = [];
    protected $observers = [];
    protected $routerLogin;
    protected $routerHome;
    protected $profileUser;
    protected $profileUserPass;
    public    $messageError;
    public    $ipRequest;

    //Event for Observer
    const EVENT_AUTH_TRUE   = 'LOGIN';
    const EVENT_AUTH_FALSE  = 'AUTH_ERROR';
    const EVENT_LOGOUT = 'LOGOUT';


    public function __construct($container) { 
        parent::__construct($container);
        $this->container = $container;
        $this->auth = $container->auth;

        $this->routerLogin = $this->container->router->pathFor('login');
        $this->routerHome = $this->container->router->pathFor('home');
        $this->routerAdd  = $this->container->router->pathFor('add_point');
        $this->profileUser = $this->container->router->pathFor('profile_user');
        $this->profileUserPass = $this->container->router->pathFor('profileUserPass');
        $this->registerObserver();
    }
    
    //----------------------------OBSERVER PATTERN -----------------------------//
    
    protected function registerObserver () {
        $this->attach($this->container->loglogintrue, self::EVENT_AUTH_TRUE);
        $this->attach($this->container->authError, self::EVENT_AUTH_FALSE);
        $this->attach($this->container->loglogout, self::EVENT_LOGOUT);
    }
    
    public function attach(\Interfaces\Observer $observer, $event) {
        $this-> observers [$event][] = $observer;
    } 
    
    public function detach(\Interfaces\Observer $observer) {
        foreach ($this->observers as $key=>$Observer){
            if($Observer === $observer){
                unset($this->observers[$key]);
            }
        }
    }

    public function notify ($event) {
        foreach ($this->observers[$event] as $observer) {
            $observer->update($this);
        }
    }
    //--------------------------------------------------------------------------//

    public function loginTemplate ($template) {
          return $this->view->fetch($template, 
                                                        [   
                                                            'routerLogin'           => $this->routerLogin,
                                                            'routerHome'            => $this->routerHome,
                                                            'profileUser'           => $this->profileUser,
                                                            'profileUserPass'       => $this->profileUserPass,
                                                            'routerAdd'             => $this->routerAdd, 
                                                            'session'               => $this->session
                                                        ]);       
    }  
    
    public function display($request, $response, $args, $tmpl = FALSE ) {
       $this->title = 'CiscoLogin';
       if ($tmpl == 'logout') {
           $this->header = 'Вы авторизованы на сайте';
       }
       
       $template = ($tmpl == 'logout') ? 'logout.php':'login.php';  
       $this->mainbar= $this->loginTemplate($template);
             parent::display_login($request, $response, $args);
    }


    public function execute ($request, $response, $args) {
        
        //Проверка нажатия кнопки входа или выхода из системы при POST запросе 
        if ($request->isPost()) {
                $posts_data = $request->getParsedBody();
                    if (isset($posts_data['logout']))
                        {  
                            return $this->logout($request, $response, $args);
                        }else if (isset($posts_data['logIn'])) {
                                return $this->login($request, $response, $args);
                        }
        }

        
        if ($this->auth->isUserLogin($request, $response)) {
            $tmpl = 'logout';
        }else {
            $tmpl = 'login';
        }
        return $this->display($request, $response, $args, $tmpl);
    }

    //Получить значения текущего пользователя, сохраненные в массиве
    public function getDataUsers() {
        return $this->dataUsers;
    }
    
    protected function ErrorAuth ($request, $message) {
                $this->ipRequest = $request->getServerParam('REMOTE_ADDR');
                $this->messageError = $message;
    }

    //Получить данные ошибки аутентификации
    public function getError() {
        return array (
                        'ip' => $this->ipRequest,
                        'message' => $this->messageError
                      );
    }

    protected function logout ($request, $response, $args){
        if (isset($this->session['sess']) && !empty($this->session['sess'])) {
            $this->model->deleteIdUserssession($this->session['sess']);
            $this->notify(self::EVENT_LOGOUT);
            $this->container->sessionData->deleteSession();
            //удаляем куки при выходе
            $this->container->cookieData->set('online_cache', ['value' => time(), 'expires' => time() - 7200, 'path' => '/']);
            $this->container->cookieData->set('timeout_session', ['value' => time(), 'expires' => time() - 7200, 'path' => '/']);
            $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
            return $response->withJson(array('url' => $this->routerLogin, 'status' => TRUE));
        } else {
            return $response->withJson(array('url' => $this->routerLogin, 'status' => TRUE));
        }
    }
    protected function login ($request, $response, $args) {
        
        $post = $request->getParsedBody();
        if (!empty($post)) {
            
            //Обработка данных запроса POST
            $login      =     trim($post['login']);
            $password   =     trim($post['password']);
            
            if (empty($login) || empty($password)){
                return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => 'Не все обязательные поля заполнены'));                            
            }
            
            //Проверка существования указананого в форме пользователя
            $password = md5($password);
            $result = $this->model->getUsersLoginPass($login, $password);
           
            if (!$result) {
              $this->ErrorAuth($request, 'Ошибка. Проверьте ваши данные для доступа');             
              $this->notify(self::EVENT_AUTH_FALSE);
              return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => $this->messageError));                  
            } 
            
            //Проверяем не заблокирован ли пользователь 
            if (!$result[0]['banned'] == 0) {
                $this->ErrorAuth($request, 'Пользователь заблокирован. Обратитесь к администратору ресурса');        
                $this->notify(self::EVENT_AUTH_FALSE);
                return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => $this->messageError));
            }
            
             //Получаем данные авторизованного пользователя
            $this->dataUsers    =   $this->container->users->AllUserData($request,$result[0]['id']);
            if( $this->model->UpdateSessiondata($this->dataUsers)) {
               //run OBSERVERS
               $this->notify(self::EVENT_AUTH_TRUE);
               $this->container->sessionData->CreateSessionData($this->dataUsers);
               //Удаление сессии при неактивности пользователя в течении максимального таймаута (константа MAX_TIME_SESSION)
               //Авторизация теряется и потребует повторно войти на сайт
               $this->container->model->deleteSessions();
                //Формируем cookies для проверки наличия пользователя в системе
               $this->container->cookieData->set('online_cache', ['value' => time(), 'path' => '/']);
               $this->container->cookieData->set('timeout_session', ['value' => time(), 'path' => '/']);
               $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
               //Возвращает ответ с установленными куками
               return $response->withJson(array('url' => $this->routerHome, 'status'=> TRUE));  
           }else { 
                    return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => 'Ошибка авторизации. Попробуйте позже')); 
                  }         
        }
                return $response->withJson(array('url' => FALSE, 'status'=> FALSE, 'message' => 'Ошибка авторизации. Попробуйте позже'));     
    }

    protected function getGallery() {
         return true;
    } 
}
