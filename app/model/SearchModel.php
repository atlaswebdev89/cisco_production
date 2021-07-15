<?php
namespace Model;
use Core\Model\MainModel;

class SearchModel extends MainModel {
    /*------------------------------------------------------------------------------------------------------------*/  


        public function SearchData ($data) {
             $type = "arraydata";
                $sql = "SELECT `".PREF."point_data`.`id`, INET_NTOA(`".PREF."point_data`.`ip`) as ip, `".PREF."point_data`.`latitude`, `".PREF."point_data`.`longitude`,"
                    . "`".PREF."point_data`.`notice`, `".PREF."point_data`.`set_place`,"
                    . "`".PREF."point_data`.`speed_download`, `".PREF."point_data`.`speed_upload`, `".PREF."point_data`.`type`, `".PREF."point_data`.`mac`, "
                    . "`".PREF."point_data`.`installation_date`, `".PREF."point_address`.`address`, `".PREF."point_ssid`.`ssid`, `".PREF."points_model`.`model`, "
                    . "`".PREF."business`.`name`"
                    . "FROM `".PREF."point_data` "
                    ."LEFT JOIN `".PREF."point_address` ON `".PREF."point_data`.`id_address` = `".PREF."point_address`.`id` "
                    ."LEFT JOIN `".PREF."business` ON `".PREF."business`.`id` =`".PREF."point_data`.`id_business`"
                    ."LEFT JOIN `".PREF."point_ssid` ON `cisco_point_ssid`.`id` =`".PREF."point_data`.`id_ssid`"
                    ."LEFT JOIN `".PREF."points_model` on `".PREF."points_model`.`id` =  `".PREF."point_data`.`id_model`"
                    ."WHERE `".PREF."point_data`.`ip` LIKE :term ORDER BY `installation_date` DESC";

                $data_array = [
                    'term' => $data
                ];
                $result =  $this->driver->query($sql, $type, $data_array);
                return $result;
        }

        //Получение всех организаций и количесвто установленных точек для каждой
        public function getOrganizations () {
            $type = "arraydata";
            $sql =  "SELECT `".PREF."business`.`id`, `".PREF."business`.`name`, "
            ." (SELECT COUNT(*) FROM `".PREF."point_data` WHERE `".PREF."point_data`.`id_business` = `".PREF."business`.`id`) as point  "
            ." FROM `".PREF."business` ORDER BY point DESC";
            $result =  $this->driver->query($sql, $type);
            return $result;
        }
}
