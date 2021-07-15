<?php

namespace Model;
use Core\Model\MainModel;

class ProfileUserModel extends MainModel{
    
    public function editUserdata (array $data) {
        $type = "count";
        $sql = "UPDATE `".PREF."users_data` set `name` = :name, `secondname` = :secondname, `phone` = :phone ,"
            . "`JobsDepartment` = :JobsDepartment "
            . " WHERE `".PREF."users_data`.`id`= :id";
        $data_array = array(
            'name' => $data['name'],
            'secondname' => $data['secondname'],
            'phone' => $data['phone'],
            'JobsDepartment' => $data['JobsDepartment'],
            'id' => $data['id_user']
        );
        $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
        
    }
    
    public function changePassUser ($id, $pass) {
        $type = "count";
        $sql = "UPDATE `".PREF."users` set `password` = :password"
            . " WHERE `".PREF."users`.`id`= :id";
        $data_array = array(
            'password' => $pass,          
            'id' => $id
        );
        $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
        
    }
    
    
}
