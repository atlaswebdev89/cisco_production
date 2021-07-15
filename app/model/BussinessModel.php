<?php

namespace Model;
use Core\Model\MainModel;

class BussinessModel  extends MainModel{

//Функция проверки наличия Организации в БД по переданному id
public function checkBussiness($id)
        {
                $type = "arraydata";
                $sql = "SELECT `id` FROM `".PREF."business` WHERE `id` =:id";
                $data_array = array(
                    'id' => $id
                );
                $result = $this->driver->query($sql, $type, $data_array);
            return $result;
        }

//Функция удаления организации из БД
public function deleteBussiness($id) {
                $type = 'count';
                $sql = "DELETE FROM `".PREF."business` WHERE `id` = :id";
                    $data_array = array (
                        'id' => $id
                    );
                $result =  $this->driver->query($sql, $type, $data_array);
            return $result;
        }
//Получение данных организации
public function getDataBussId($id){
                $type = "arraydata";
                $sql = "SELECT * FROM `".PREF."business` WHERE `id` =:id";
                $data_array = array(
                    'id' => $id
                );
                $result = $this->driver->query($sql, $type, $data_array);
            return $result;
        }

//Получение всех точек организации
public function getPointBussId($id){
                $type = "arraydata";
                $sql = "SELECT `".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip, `".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
                . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`,"
                . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
                . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
                . "`".PREF."business`.`name`"
                    . "FROM `".PREF."point_data` "
                ." LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
                ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
                ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
                ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`"
                    ."WHERE `".PREF."point_data`.`id_business` =:id ORDER BY `installation_date` DESC";
                    $data_array = array(
                        'id' => $id
                    );
                $result = $this->driver->query($sql, $type, $data_array);
            return $result;
        }


//Изменение данных организации  в БД
public function editBussinessdata (array $data) {
            $type = "count";
            $sql = "UPDATE `".PREF."business` set `name` = :name, `placemark_color` =:color, `description` =:description "
                . " WHERE `".PREF."business`.`id`= :id";
                $data_array = array(
                    'name' => $data['name'],
                    'color' => $data['color'],
                    'id' => $data['id'],
                    'description' => $data['description']
                );
            $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
    }


    
//Добавить новую организацию в бд
public function addBus (array $data) {
     $type = "insert";
     $sql = "INSERT INTO `".PREF."business` SET `name` =:name, `description` =:description, `placemark_color` =:placemark_color";
        $data_array = array(
            'name' => $data['name'],
            'description' => $data['description'],
            'placemark_color' => $data['color']
        );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    }


public  function  getdataAddressPoint ($id) {
            $type = "arraydata";
                $sql = "SELECT `".PREF."point_data`.`id_address`, `".PREF."point_address`.`address`, COUNT(`".PREF."point_data`.`id`) as point FROM `".PREF."point_data`"
                ."LEFT JOIN `".PREF."point_address` ON `".PREF."point_address`.`id` = `".PREF."point_data`.`id_address`"
                ."WHERE `".PREF."point_data`.`id_business` =:id GROUP BY `".PREF."point_data`.`id_address` ORDER BY point DESC";
            $data_array = array(
                'id' => $id
            );
            $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
    }

}
