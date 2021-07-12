<?php

namespace Core\Router;

class Router {
   
   protected $app;
   protected $container;
   
   public function __construct($app) {
       $this->app = $app;
    }
    
   public function createRoutes() {
        
        //Группа маршрутов для пользовательской части
         $this->app->group('', function () {
                $this->get('/', '\Controller\IndexController:execute')->setName('home');
                $this->get('/info[/]', '\Controller\IndexController:execute') ->setName('info');
                $this->get('/denied[/]',  '\Controller\DeniedController:execute')->setName('denied');
                $this->get('/reports/',     '\Controller\ReportsController:execute');
                $this->get('/csv/',         '\Controller\ReportsController:csv');

                //Редактирование данных пользователя и смена пароля
                $this->get('/profileUser' ,                         '\Controller\ProfileUsersShowController:execute') ->setName('profile_user_show');
                $this->map(['GET', 'POST'], '/profileUserEdit/',    '\Controller\ProfileUserController:execute')      ->setName('profile_user');
                $this->map(['GET', 'POST'], '/profileUserPass/',    '\Controller\ProfileUserControllerPass:execute')  ->setName('profileUserPass');

                //Поиск
                $this->map(['GET', 'POST'], '/search/[page/{id}[/]]',              '\Controller\SearchController:execute')->setName('search');

                //Группа маршрутов для Организаций
                $this->group ('/bussiness', function () {
                   $this->get('[/[page/{id}[/]]]',                          '\Controller\BussinessControllerShowAll:execute')   ->setName('bussiness');
                   $this->get('/show/id/{id}',                              '\Controller\BussinessControllerShow:execute')      ->setName('bussiness_show');
                   $this->post('/delete[/]',                                '\Controller\BussinessControllerDelete:execute')    ->setName('bussiness_delete');
                   $this->get('/points/show/id/{id}[/[page/{page}[/]]]',    '\Controller\BussinessControllerShowPoint:execute') ->setName('bussiness_point');
                   $this->get('/{bus}/address/show/{id}[/page/{page}[/]]',  '\Controller\BussinessControllerShowAddress:execute') ->setName('bussiness_pointAddress');
                   $this->get('/edit/id/{id}',                              '\Controller\BussinessControllerEdit:execute')      ->setName('edit_bussiness_show');
                   $this->post('/edit[/]',                                  '\Controller\BussinessControllerEdit:edit')         ->setName('edit_bussiness');
                   $this->map(['GET', 'POST'], '/add[/]',                   '\Controller\BussinessControllerAdd:execute')       ->setName('add_bussiness');
                });

                //Группа маршрутов для точек доступа
                $this->group('/point', function () {
                   $this->get('[/[page/{id}[/]]]',                  '\Controller\PointControllerShowAll:execute')   ->setName('points');
                   $this->get('/show/id/{id}',                      '\Controller\PointControllerShow:execute')      ->setName('show_point');
                   $this->post('/delete[/]',                        '\Controller\PointControllerDelete:execute')    ->setName('delete_point');
                   $this->post('/checkIpPoint[/]',                  '\Controller\PointControllerCheck:execute')     ->setName('check_point');
                   $this->map(['GET', 'POST'], '/add[/]',           '\Controller\PointControllerAdd:execute')       ->setName('add_point');
                   $this->get('/edit/id/{id}',                      '\Controller\PointControllerEdit:execute')      ->setName('edit_point_show');
                   $this->post('/edit[/]',                          '\Controller\PointControllerEdit:edit')         ->setName('edit_point');
                   $this->get('/maps[/[id/{id}[/]]]',               '\Controller\PointControllerMaps:execute' )     ->setName('points_maps');
                   $this->get('/maps/bussiness/id/{id}[/]',         '\Controller\PointControllerMaps:showMapsBussiness' )     ->setName('points_maps_bussiness');
                   $this->post('/search[/]',                        '\Controller\PointControllerSearch:execute' )   ->setName('points_search');

                });

         })->add('\Core\Middleware\Middleware:AuthLogin');
          
         $this->app->get('/testing/',     '\Controller\TestingController:execute2');
         
         
         $this->app->map(['GET', 'POST'], '/login[/]', '\Controller\LoginController:execute')->setName('login');



            
            
            
//        $this->app->get('/admin', '\Controller\AdminController:execute')->setName('admin')->add('\Atlas\Middleware:AuthLogin');
//        $this->app->get('/admin/onlineusers', '\Controller\UsersController:execute')->setName('users')->add('\Atlas\Middleware:AuthLogin');
//        $this->app->map(['GET', 'POST'], '/login', '\Controller\LoginController:execute')->setName('login');  
//        $this->app->get('/env', function ($request, $response, $args){
//            echo '<pre>';
//            var_dump($this->environment);
//            echo \Wifi\TimePage::finish_time();
//                    
//              echo '</pre>';
//        })->setName('env');
        
        
//  Группа маршрутов для Admin панели
//        $this->app->group('/admin', function () {
//           $this->get('/',  '\Atlas\CallbackRouters:home');
//               $this->group('/views', function (){
//                    $this->get('/', '\Atlas\CallbackRouters:home');
//        });    
//    });
    }
}
