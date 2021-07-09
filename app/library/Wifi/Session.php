<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Wifi;


class Session {
    
    protected $session;
    public function __construct() {
        $this->session = $_SESSION;
    }

    public function CreateSessionData (array $data) {
        
                $_SESSION['sess']               =   $data['sess'];
                $_SESSION['name']               =   $data['name'];
                $_SESSION['secondname']         =   $data['secondname'];
                $_SESSION['user_id']            =   $data['id'];
                $_SESSION['role']               =   $data['role'];
                $_SESSION['role_alias']         =   $data['role_alias'];
                $_SESSION['ip']                 =   $data['ipAddress'];
                $_SESSION['user_agent']         =   md5($data['user_agent']); 
                $_SESSION['phone']              =   $data['phone'];
                $_SESSION['JobsDepartment']     =   $data['JobsDepartment'];
                $_SESSION['time']               =   date("H:i:s");
                $_SESSION['timeLogin']          =   date("H:i:s", $data['timelogin']);
                $_SESSION['auth']               =   TRUE;
                $_SESSION['sessionTime']        =   $data['sessionTime'];
                $_SESSION['menu']               =   $data['menu'];
                //Включаем дополнительные проверки 
                $_SESSION['checkIP']            =   $data['checkIP'];
                $_SESSION['checkAgent']         =   $data['checkAgent'];
    }
    
    public function deleteSession (){
        unset($_SESSION['sess']);
        session_destroy();
    }
    
    public function updatesessionDataUser (array $data) {    
            $_SESSION['name'] = $data['name'];
            $_SESSION['secondname'] = $data['secondname'];
            $_SESSION['phone'] = $data['phone'];
            $_SESSION['JobsDepartment'] = $data['JobsDepartment'];            
    }
    
}
