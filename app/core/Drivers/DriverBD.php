<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Drivers;

/**
 * Description of DriverDB
 *
 * @author atlas
 */
class DriverBD {
    
    protected static $db;
    protected  $count_sql = 0; 
    
    public function __construct($pdo) {
        if (isset ($pdo)){
            self::$db = $pdo;
        }else 
            throw new \PDOException ("Нет подключения к БД");
    }
    
    public function getCountBD (){
        return $this->count_sql;
    }


    public function query ($sql, $type, array $data = NULL){
        $this->count_sql++; 
        switch ($type){
            case 'arraydata':                
                    $row =  self::$db->prepare($sql);
                    $row->execute($data);
                return $row->fetchAll();
            case 'count':                
                    $row =  self::$db->prepare($sql);
                    $row->execute($data);
                return $row->rowCount();
            case 'insert':
                    $row = self::$db->prepare($sql);
                    $row->execute($data);
                return self::$db->lastInsertId();
            break;
        }
    }
}
