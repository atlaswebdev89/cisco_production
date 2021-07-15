<?php

namespace Model;
use Core\Model\MainModel;

class PointModel extends MainModel {

/*--------------------------------------------------POINTS-----------------------------------------------------*/ 

// Получение сохраненных в базе адресов
 public function getAddressForSelect () {
        $type = 'arraydata';       
        $sql = "SELECT * FROM `".PREF."point_address`"; 
        $result =  $this->driver->query($sql, $type); 
        return $result;  
 }
 
 //Получение организаций сохраненных в БД
 public function getBusinessForSelect () {
     $type = 'arraydata'; 
     $sql = "SELECT * FROM `".PREF."business`";
     $result = $this->driver->query($sql, $type);
     return $result;
 }
 
 //Получение используемых моделей точек Cisco 
 public function getModelCiscoForSelect () {
     $type = 'arraydata'; 
     $sql = "SELECT * FROM `".PREF."points_model`";
     $result = $this->driver->query($sql, $type);
     return $result;
 }
 //Получение Ssid из бд getSsidForSelect
 public function getSsidForSelect () {
     $type = 'arraydata'; 
     $sql = "SELECT * FROM `".PREF."point_ssid`";
     $result = $this->driver->query($sql, $type);
     return $result;
 }
 
 //Получение списка скоростей доступа к сети 
 public function getSpeedForSelect () {
     $type = 'arraydata'; 
     $sql = "SELECT * FROM `".PREF."point_speed`";
     $result = $this->driver->query($sql, $type);
     return $result;
 } 
 
 //Проверка наличия ip адреса точки в БД для формы добавления новой точки Чтобы не было дублей
 public function checkIpPoint ($ip) {
     $type ="count";
     $sql = "SELECT ip FROM `".PREF."point_data` where ip = :ip";
     $data_array=array(
                    'ip'  => $ip
                );    
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 }
 
 
 
 
//Проверить наличие органиции в бд
 public function getBusines ($name) {
     $type = "arraydata";
     $sql = "SELECT `id` FROM `".PREF."business` WHERE name =:name";
     $data_array = array (
         'name' => $name
     );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 }
 
 public function getBusinesForId ($id) {
     $type ="count";
     $sql = "SELECT * FROM `".PREF."business` WHERE id =:id";
     $data_array=array(
                    'id'  => $id
                );    
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 }
 
//Добавить новую организацию в бд
 public function addBusines ($name) {
     $type = "insert";
     $sql = "INSERT INTO `".PREF."business` SET `name` =:name";
        $data_array = array(
            'name' => $name
        );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    }

//Проверить наличие ssid в бд
 public function getSsid ($name) {
     $type = "arraydata";
     $sql = "SELECT `id` FROM `".PREF."point_ssid` WHERE `ssid` =:name";
     $data_array = array (
         'name' => $name
     );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 }
 
 public function getSsidForId($id) {
     $type = "arraydata";
     $sql = "SELECT * FROM `".PREF."point_ssid` WHERE `id` =:id";
     $data_array = array (
         'id' => $id
     );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 }
 
 //Добавить новую ssid в бд
 public function addSsid($name) {
     $type = "insert";
     $sql = "INSERT INTO `".PREF."point_ssid` SET `ssid` =:name";
        $data_array = array(
            'name' => $name
        );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    }  
    
  //Проверить наличие адреса в бд
 public function getAddress ($name) {
     $type = "arraydata";
     $sql = "SELECT `id` FROM `".PREF."point_address` WHERE `address` =:name";
     $data_array = array (
         'name' => $name
     );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
 } 
 //Добавить новый адрес в БД
 public function addAddress($name) {
     $type = "insert";
     $sql = "INSERT INTO `".PREF."point_address` SET `address` =:name";
        $data_array = array(
            'name' => $name
        );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    } 
    
  //Добавление данных точки в БД 
    public function adddatapointBd (array $data)
    {
        $type = "insert";
        $sql = "INSERT INTO `" . PREF . "point_data` (ip, latitude, longitude, id_address, id_business, notice, set_place, "
            . "speed_download, speed_upload, id_ssid, type, id_model, mac, installation_date, schema_connect, customer, payment, responsibility) values (:ip, :latitude, :longitude, "
            . ":id_address, :id_business, :notice, :set_place, "
            . ":speed_download, :speed_upload, :id_ssid, :type, :id_model, :mac, :installation_date, :schema_connect, :customer, :payment, :responsibility)";
        $data_array = array(
            'ip' => $data['ip'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'id_address' => $data['id_address'],
            'id_business' => $data['id_business'],
            'notice' => $data['notice'],
            'set_place' => $data['set_place'],
            'speed_download' => $data['speed_download'],
            'speed_upload' => $data['speed_upload'],
            'id_ssid' => $data['id_ssid'],
            'type' => $data['type'],
            'id_model' => $data['id_model'],
            'mac' => $data['mac'],
            'installation_date' => $data['installation_date'],
            'schema_connect' => $data['schema'],
            'customer' => $data['customer'],
            'payment' => $data['payment'],
            'responsibility' => $data['responsibility']
        );
        $result = $this->driver->query($sql, $type, $data_array);
        return $result;
    }

//Удаление точки из БД
    public function deletePoint($id){
         $type = 'count';
         $sql = "DELETE FROM `".PREF."point_data` WHERE `id` = :id";
            $data_array = array (
                'id' => $id
            );
        $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
    }
    
//Проверка наличие точки с указаным id в БД
    public function checkPoint ($id) {
        $type = "arraydata";
        $sql = "SELECT `id` FROM `".PREF."point_data` WHERE `id` =:id";
            $data_array = array (
             'id' => $id
            );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    }
    
   //Получение всех данных точки из БД по id
    public function getDataPointId($id) {
        $type = "arraydata";
        $sql = "SELECT `".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip,  `".PREF."point_data`.`payment`, `".PREF."point_data`.`responsibility`,`".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
            . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`, `".PREF."point_data`.`schema_connect`, `".PREF."point_data`.`customer`,  "
            . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
            . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
            . "`".PREF."business`.`name`, `".PREF."business`.`placemark_color`"
                . "FROM `".PREF."point_data` "
                    ."LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
                    ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
                    ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
                    ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`" 
                . " WHERE `".PREF."point_data`.`id`= :id";
            $data_array = array (
             'id' => $id
            );
     $result =  $this->driver->query($sql, $type, $data_array); 
     return $result;  
    }


    //Получение всех данных точки из БД для которых указанна координа для карт Яндекс
    public function getDataPoint() {
        $type = "arraydata";
        $sql = "SELECT `".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip, `".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
            . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`,"
            . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
            . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
            . "`".PREF."business`.`name`, `".PREF."business`.`placemark_color`"
            . "FROM `".PREF."point_data` "
            ."LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
            ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
            ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
            ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`"
            ."WHERE `".PREF."point_data`.`longitude` > 0 and `".PREF."point_data`.`latitude` > 0 "
            ."ORDER BY `installation_date` DESC";
        $result =  $this->driver->query($sql, $type);
        return $result;
    }
    

    //Редактирование данных точки wifi в БД
    public function editdatapointBd (array $data) {
     $type = "count";
        $sql = "UPDATE `".PREF."point_data` set `ip` = :ip, `payment`= :payment, `latitude` = :latitude, `longitude` = :longitude ,"
            . "`notice` = :notice, `set_place`= :set_place, `id_address` = :id_address, `id_business` = :id_business,"
            ." `speed_download` = :speed_download, `speed_upload` =:speed_upload, `id_ssid` =:id_ssid,"
            ."`type`=:type, `id_model`=:id_model, `mac`=:mac, `installation_date`= :installation_date,"
            ."`schema_connect` =:schema_connect, `customer` =:customer, `responsibility` =:responsibility "
            . " WHERE `".PREF."point_data`.`id`= :id";
        $data_array = array(
            'id' => $data['id'],
            'ip' => $data['ip'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'id_address' => $data['id_address'],
            'id_business' => $data['id_business'],
            'notice' => $data['notice'],
            'set_place' => $data['set_place'],
            'speed_download' => $data['speed_download'],
            'speed_upload' => $data['speed_upload'],
            'id_ssid' => $data['id_ssid'],
            'type' => $data['type'],
            'id_model' => $data['id_model'],
            'mac' => $data['mac'],
            'installation_date' => $data['installation_date'],
            'schema_connect' => $data['schema'],
            'customer' => $data['customer'],
            'payment' => $data['payment'],
            'responsibility' => $data['responsibility']
        );
        $result =  $this->driver->query($sql, $type, $data_array);
        return $result;
    }
}
