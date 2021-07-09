<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wifi;

/**
 * Description of AuthUser
 *
 * @author atlas
 */
class AuthUser {
    
    protected $db;
    protected static $_instance;

    protected function __construct($pdo) {
        $this->db = $pdo;
    }
    
    static public function getInstance ($pdo) {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }
            self::$_instance = new self($pdo);
        return self::$_instance;
    }
    
    protected function validUsers ($sess) {
        
         //Проверка существует ли пользователь с указанным id сессии в БД
  
        $sql  = "select  `id_session`, INET_NTOA(`ip_address`) "
             . " as `ip_addr`, `agent_user_hash` FROM `".PREF."users_data_auth`  "
                . " WHERE `id_session` = :sess";

                  $row = $this->db->prepare($sql);
                  $row ->execute (array (
                            'sess' => $sess
                  ));
             return  $row  = $row->fetchAll();
    }

    //Проверка выполнил ли вход пользователь
    public function isUserLogin ($request, $response) {
        if (isset($_SESSION['sess']) && !empty($_SESSION['sess'])){
    //Находим разницу в минутах между авторизацией Если прошло больше 60 секунд проверяет пользователя через БД. Иначе по установленому значению в массиве $_SESSION
            if (isset($_SESSION['time']) && !empty($_SESSION['time']))
                {
                    $datetime1 = new \DateTime($_SESSION['time']);
                    $datetime2 = new \DateTime(date("H:i:s"));  
                    $interval = $datetime1->diff($datetime2);
                    if (($interval->format('%i'))>1) 
                        {
                            $_SESSION['auth'] = FALSE;
                        } 
                }else   {
                            $_SESSION['auth'] = FALSE;
                        }
            
                
        if (isset($_SESSION['auth']) && !empty($_SESSION['auth']) && ($_SESSION['auth']) == TRUE) { 
            return $_SESSION['auth'];
            }

            $sess = $_SESSION['sess'];

           //Проверка существует ли пользователь с указанным id сессии в БД
                      $row = $this->validUsers($sess);
                      if (count($row) == 0 || count($row) > 1) {
                                return FALSE;
                       }
    
                         $ip_addr =     $row[0]['ip_addr'];
                         $userAgent =   $row[0]['agent_user_hash'];
                         
                         
                         //Проверка поменялся ли ip адрес пользователя
                         if (isset($_SESSION['checkIP']) && $_SESSION['checkIP'] ==TRUE ) {
                            if(!$this->IpUserValid($request, $response, $ip_addr)){
                               return FALSE;
                            } 
                         }
                         
                         //Проверка поменялся ли браузер
                         if (isset($_SESSION['checkAgent']) && $_SESSION['checkAgent'] == TRUE ) {
                                if(!$this->AgentUserValid($request, $response, $userAgent)){
                                   return FALSE;
                                } 
                         }
                         
                         $_SESSION['time'] = date("H:i:s");
                         $_SESSION['auth'] = TRUE;
                    return $row;
            }else {
                return FALSE;
            }
        }
        
        //Функция проверки ip адреса пользователя и запись значения в сессию если её там нет или не соответствует текущему значению
        protected function IpUserValid ($request, $response, $ip_bd) {
            $ipAddress = $request->getServerParam('REMOTE_ADDR');
            if ($ipAddress == $ip_bd) {            
                if (!isset($_SESSION['ip']) || empty($_SESSION['ip']) || ($_SESSION['ip'] != $ipAddress)) {
                                    $_SESSION['ip'] = $ip_addr;
                                }        
                return TRUE;
            }else 
                return FALSE;
        }
        
        //Функция проверки данных браузера 
        protected function AgentUserValid ($request, $response, $userAgent) {
            $user_agent = md5($request->getServerParam('HTTP_USER_AGENT'));
            if ($user_agent == $userAgent){
                 if (!isset($_SESSION['user_agent']) || empty($_SESSION['user_agent']) || ($_SESSION['user_agent'] != $user_agent)) {
                                    $_SESSION['user_agent'] = $user_agent;
                                }       
                return TRUE;
            }else 
                return FALSE;
        }
    }

