<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Connect;

/**
 * Description of ConnectDB
 *
 * @author atlas
 */
class ConnectDB {
    private static $connect;
    private static $_instance;
    
    protected function __construct($db) {
           $this->connectDB($db);
    }
    
    protected function connectDB ($db) {
        if (self::$connect instanceof \PDO) {
            return self::$connect;
        }
        self::$connect = new \PDO ("mysql:host=". $db['host'].";dbname=".$db['dbname'].";charset=utf8", $db['user'], $db['password'] );
            self::$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);    
     return self::$connect;
    }
    
    static public function getInstance ($db) {
        if (self::$_instance === null) {
			self::$_instance = new self($db);  
		}
		return self::$_instance;
    }

    public function getConnect () {
        return self::$connect;
    }
}