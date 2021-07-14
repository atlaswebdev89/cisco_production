<?php

namespace Core\BootLoader;
use \Slim\App as App;

class Bootstrap {
   
    static public function registerDI ($app) {
        if ($app instanceof App){
            //Создаем контайнер DI
            $container = $app->getContainer();
            //var_dump($container);exit;
                        //register DB user data
                        $container['db'] = function ($container) {
                            return $container ['settings']['db'];
                        };
                        
                        //Register dataBase connection (PDO) Singleton
                        $container['pdo'] = function ($container) {
                                $db = $container ['db'];
                                $connect = \Core\Connect\ConnectDB::getInstance($db);
                            return $connect->getConnect();
                        };

                        //Model MVC
                        $container ['driver'] = function ($container) {
                            return new \Core\Drivers\DriverBD($container['pdo']);
                        };
                        
                        $container ['model'] = function ($container) {
                            return new \Core\Model\Model($container['driver']);
                        };

                        //register AuthClass 
                        $container ['auth'] = function ($container) {
                                $pdo = $container['pdo'];
                          return \Wifi\AuthUser::getInstance($pdo);
                        };
                        //register PermissionsRoleclass
                        $container ['acl'] = function ($container) { 
                          return \Wifi\AclUser::getInstance($container);
                        };
                        //----------register Observer-------------------------------------------------//
                        $container['loglogintrue'] = function ($container) {
                          return new \Wifi\LogLoginTrue($container['model']);  
                        };
                        $container['authError'] = function ($container){
                            return new \Wifi\LogAuthError ($container['model']);
                        };
                        $container['loglogout'] = function ($container){
                            return new \Wifi\LogLogout ($container['model']);
                        };
                        //----------------------------------------------------------------------------//

                        //Register component on container (Подключение twig-slim шаблонизатора)
                        $container['view'] = function ($container) {
                                $view = new \Slim\Views\Twig('templates');     
                            return $view;
                        };

                        //Register ClassUser dataUser
                        $container['users'] = function ($container) {
                            return new \Wifi\Users($container['model']);
                        };

                        //Register Session and Cookie Class
                        $container['sessionData'] = function ($container) {
                            return new \Wifi\Session();
                        };

                        $container['cookieData'] = function ($container) {
                            return new \Wifi\Cookie();
                        };

                        //Класс проверки роли пользователя для отображения определенных блоков
                        $container['viewsblockrole'] = function ($container) {
                            return new \Wifi\ViewsBlockRole();
                        };

                        //Класс для постраничной пагинации
                        $container['pager'] = function ($container){
                          return new \Wifi\Pager($container['driver']);
                        };


                        //Класс для формирование отчетов
                        $container['reports'] = function ($container){
                            return new \Wifi\ExcelReports($container['model']);
                        };
                        
                        
                        //Посредник выполнения запросов в модель
                        $container['dataClient']=  function ($container){
                            return new \Core\Drivers\DataDrivers($container);
                        };
                        
                        //Обработчик 404 ошибки
                        $container['notFoundHandler'] = function ($container) {
                           return function ($request, $response) use ($container) {
                                return $container->view->render($response, '404.php')
                                    ->withStatus(404)
                                    ->withHeader('Content-Type', 'text/html');
                            };
                        };
                        //Обработчик 405 ошибки
                        $container['notAllowedHandler'] = function ($container) {
                            return function ($request, $response) use ($container) {
                                return $container->view->render($response, '404.php')
                                    ->withStatus(404)
                                    ->withHeader('Content-Type', 'text/html');
                            };
                        };
                return $container;
        }
    }
}
