<?php

error_reporting(E_ALL);

//Вывод ошибок
ini_set('display_errors', 1);
//Время жизни сесии в секундах
ini_set('session.gc_maxlifetime', 1440);

//Включение лога ошибок и указания файла для записи. Работает при выключенно внутреннем обработчике Slim
ini_set('log_errors', 'On');
ini_set('error_log', '/var/log/php/php_errors.log');


//Настройка планировщика удаления файлов сессий
//Вероятность запуска GC при каждом запуске скрипта  - session.gc_probability / session.gc_divisor
//По умолчанию - 1/100. Соответственно, если задать session.gc_probability = 0 GC не запустится никогда
ini_set('session.gc_probability', 100);
ini_set('session.gc_divisor', 100); 


//Путь до каталога с файлами сессий
ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'].'/sessions');
// Время жизни куки в секундах
// 0 - по завершению текущего сеанса браузера (при закрытии браузера не всегда сеанс заканчивается. Зависит от браузера))
ini_set('session.cookie_lifetime', 0);

require_once 'vendor/autoload.php';
require_once 'config/config.php';

//Время формирования страницы и размер использованной памяти
Wifi\TimePage::start();

$config = [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        //Подробнная инфа по ошибке
        'displayErrorDetails' => true,
        'debug' => true,
        'templates.path' => __DIR__.'/templates',
        
        'db' => [
            'host' =>       HOST,
            'dbname' =>     DBNAME,
            'user' =>       USER,
            'password' =>   PASSWORD
            ],
    ],    
];

session_start(); //Start Session 

$app = new \Slim\App($config);

$container = $app->getContainer();

//register DB user data
$container['db'] = function ($container) {
    return $container ['settings']['db'];
};

//Register dataBase connection (PDO) Singleton
$container['pdo'] = function ($container) {
        $db = $container ['db'];
        $connect = \Model\ConnectDB::getInstance($db);
    return $connect->getConnect();
};

//Model MVC
$container ['driver'] = function ($container) {
    return new \Model\DriverBD($container['pdo']);
};
$container ['model'] = function ($container) {
    return new \Model\Model($container['driver']);
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

// Отключение обработчика ошибок Slim и включение стандартного обработчика PHP
//unset($app->getContainer()['errorHandler']);
//unset($app->getContainer()['phpErrorHandler']);

//Сессия таймаут
$app->add('\Wifi\Middleware:timeout');
//Пользователи онлайн ()
$app->add('\Wifi\Middleware:OnlineUserUpdate');

$router = new \Wifi\Router($app);
$router->createRoutes();

//Запуск приложения  
$app->run();
