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

////По умолчанию - 1/100. Соответственно, если задать session.gc_probability = 0 GC не запустится никогда

//ini_set('session.gc_probability', 100);
//ini_set('session.gc_divisor', 100); 

//Путь до каталога с файлами сессий
//ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'].'/sessions');
// Время жизни куки в секундах
// 0 - по завершению текущего сеанса браузера (при закрытии браузера не всегда сеанс заканчивается. Зависит от браузера))
ini_set('session.cookie_lifetime', 0);

require_once 'vendor/autoload.php';
require_once 'config/config.php';

//Количество затраченной памяти 
\Core\Extensions\UsageMemory::start();
//Время формирования страницы и размер использованной памяти
$time_load_page = \Core\Extensions\Timer::getInstanse('start');

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
$container = \Core\BootLoader\Bootstrap::registerDI($app);

// Отключение обработчика ошибок Slim и включение стандартного обработчика PHP
//unset($app->getContainer()['errorHandler']);
//unset($app->getContainer()['phpErrorHandler']);

//Сессия таймаут
$app->add('\Core\Middleware\Middleware:timeout');
//Пользователи онлайн ()
$app->add('\Core\Middleware\Middleware:OnlineUserUpdate');

$router = new \Core\Router\Router($app);
$router->createRoutes();

//Запуск приложения  
$app->run();
