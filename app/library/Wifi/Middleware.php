<?php

namespace Wifi;

class Middleware {
    
    protected $container;
    protected $denied;
    public function __construct($container) {
       $this->container     = $container;
       $this->redirect      = $this->container->router->pathFor('login');
       $this->denied        = $this->container->router->pathFor('denied');

       //Обекты для проверки пользователя и его прав
       $this->auth          = $container->auth;
       $this->acl           = $container->acl;
    } 

    public function AuthLogin ($request, $response, $next) {
    
    //Получение текущего маршрута 
        $routeInfo = $request->getAttribute('routeInfo');
        $url = $routeInfo['request'][1];
        $route = $request->getAttribute('route');
        $name = $route->getName();
        $groups = $route->getGroups();
        $methods = $route->getMethods();
        $arguments = $route->getArguments();

        $uri = $request->getUri()->getpath();
        $method = $request->getMethod();

        
     if (isset($_SESSION['sess']) && !empty($_SESSION['sess'])) {
         //Проверка авторизации пользователя
         if (!$user = $this->auth->isUserLogin($request, $response)) {
                //ДВА способа сделать редирект
//              return   $response->withStatus(302)->withHeader('Location', '/login');
                return $response->withRedirect($this->redirect);
            }  
            
         //Проверка прав доступа 
         if (isset($_SESSION['role_alias']) && !empty($_SESSION['role_alias'])) {
                if (!$this->acl->check($uri, $_SESSION['role_alias'] )){

                    // В зависимости от метода возвращаем или обычный редирект или json с указает uri для перенаправления
                    switch ($method) {
                        case 'GET':
                            return $response->withRedirect($this->denied);
                        case 'POST':
                            return $response->withJson(array('status'=> 'denied', 'url' => $this->denied));
                    }

                }
            }            
        } else {
                    return $response->withRedirect($this->redirect);
                }
 
        $response = $next($request, $response);     
    return $response;
    }
    
    public function timeout ($request, $response, $next) {
        
        //РАССМОТРЕТЬ ВОЗМОЖНОСТЬ РАБОТЫ ЧЕРЕЗ ПЛАНИРОВЩИК CRON ЦЕЛЬ: уменьшить количество запросов в БД при формировании страницы

        if (isset($_SESSION['sess']) && !empty($_SESSION['sess'])) {
            if(isset($_COOKIE['timeout_session']) && !empty($_COOKIE['timeout_session'])){
                if($_COOKIE['timeout_session'] < (time() - $_SESSION['sessionTime'])){
                        $this->container->model->deleteIdUserssession($_SESSION['sess']);
                        $this->container->model->updateLogTimeout($_SESSION['sess']);
                        $this->container->sessionData->deleteSession();
                        $this->container->cookieData->set('online_cache', ['value' => time(), 'expires' => time() - 7200, 'path' => '/']);
                        $this->container->cookieData->set('timeout_session', ['value' => time(), 'expires' => time() - 7200, 'path' => '/']);
                        $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
                        $response = $next($request, $response);
                    return $response;
                }  else { 
                    $this->container->cookieData->set('timeout_session', ['value' => time(), 'path' => '/']);
                    $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
                }  
            }else {
                    $this->container->model->deleteIdUserssession($_SESSION['sess']);
                    $this->container->model->updateLogTimeout($_SESSION['sess']);
                    $this->container->sessionData->deleteSession ($_SESSION['sess']);
                    $this->container->cookieData->set('online_cache', ['value' => time(), 'expires' => time() - 7200, 'path' => '/']);               
                    $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
                    $response = $next($request, $response);
                    return $response;
            }    
        } 
        $response = $next($request, $response);
        return $response; 
    }
    
    public function OnlineUserUpdate ($request, $response, $next){
        if (isset($_SESSION['sess']) && !empty($_SESSION['sess'])) {
            if(isset($_COOKIE['online_cache']) && !empty($_COOKIE['online_cache'])){
                if($_COOKIE['online_cache'] < (time() - INTERVAL_UPDATE)) {
                    //Обновлении метки времени у пользователя при активности на сайте
                    $this->container->model->updateTimeSessions($_SESSION['sess']);
                    $this->container->cookieData->set('online_cache', ['value' => time(), 'path' => '/']);
                    $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
                }
            }else {
                    $this->container->cookieData->set('online_cache', ['value' => time(),'path' => '/']);
                    $response = $response->withHeader('Set-Cookie', $this->container->cookieData->toHeaders());
            }
            
         }
            $response = $next($request, $response);
        return $response;
    }
}