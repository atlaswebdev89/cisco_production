<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wifi;


class AclUser {
    
    protected static $_instance;
    protected $model;
    protected $allow = array();
    
    protected function __construct($container) {
        $this->model = $container->model;
        $this->allow = $this->setAllowAllRole();
    }

    static public function getInstance ($container) {
        if (self::$_instance === null) {
			self::$_instance = new self($container);  
		}
		return self::$_instance;
    }
    
    protected function setAllowAllRole () {
        $i=0;
        $array= [];
        $data = $this->model->getRolePermisions();
        foreach ($data as $item) {
            if (!isset($array[$item['role']]))
                    {
                        $i = 0;  
                    }
              $array[$item['role']][++$i]['resource'] = $item['permissions'];
                  if ($item['sh']     == TRUE) {$array[$item['role']][$i]['actions'][]    = 'show';}
                  if ($item['a']      == TRUE) {$array[$item['role']][$i]['actions'][]    = 'add';}
                  if ($item['e']      == TRUE) {$array[$item['role']][$i]['actions'][]    = 'edit';}
                  if ($item['del']    == TRUE) {$array[$item['role']][$i]['actions'][]    = 'delete';}     
        }
        return $array;
    }

    public function getAllow () {
        return $this->allow;
    }
    
    public function check ($permission, $role) {
       //print_r($this->allow);exit;
        //Список разрешений
        $array = array(
            'show', 
            'add', 
            'edit', 
            'delete'
        );

        //Разделы доступ к которому имеют все пользователи
        $not_denied = [
            'denied',
            'profileUser',
            'profileUserEdit',
            'profileUserPass',
            'reports',
            'csv'
        ];

        //Разбираем uri запроса определяем раздел (подраздел если есть) и метод которой запросил пользователь     
        if ($permission == '/') {
            $permission =   'home';
            $action     =   'show';
        }else {
            $ex = explode('/', $permission);
            $ex = array_values(array_diff($ex, array('')));

            //Получаем действия из запроса
            foreach ($array as $item) {
                if(in_array($item, $ex)){
                    $action = $item;
                    break;
                }else {
                    $action = 'show';
                }
           }


            if(isset($ex[0]) && !empty($ex[0])) {
                                $permission =  $ex[0];
                            }     
        }

            if (in_array($permission, $not_denied)) {
                return TRUE;
            }
        
        if (empty($this->allow)){
            return;
        }
       
        //Удаляем последний слеш при его наличии в uri запроса
        if (strlen($permission)>1 && $permission{strlen($permission)-1} == '/')
        {
            $permission = substr($permission,0,-1);
        }
      
        //Проверка по массиву разрешений есть ли доступ к запрошенному разделу
        if (array_key_exists($role, $this->allow)) {   
            foreach ($this->allow[$role] as $item) {   
                if(in_array($permission, $item)) 
                         {                               
                             if(in_array($action, $item['actions']))  
                                     {     
                                        return TRUE;
                                     }                
                         }
            }
            return FALSE;
        }
        return FALSE;
    }
}
