<?php

namespace Core\Drivers;

class DriverBD {
    
    protected static $db;
    protected $count_sql = 0; 
    protected $time_query = 0;
    protected $object_time;
    protected $sqlDatatime = [];
    
    public function __construct($pdo) {
        if (isset ($pdo)){
            self::$db = $pdo;
        }else 
            throw new \PDOException ("Нет подключения к БД");
    }

    public function queryBD ($sql, $type, array $data = NULL){
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
    
    //Функция посредник определяет время выполнения всех sql запросов
    public function query($sql, $type, array $data = NULL) {
            $this->count_sql++;
                $this->object_time= \Core\Extensions\Timer::getInstanse('start');
                    $result = $this->queryBD($sql,$type,$data);
                $this->timeQueryAll()->addDataTime($sql);
            return $result;
    }
    
    //Функция суммирования времени выполнения всех запросов к БД
    protected function timeQueryAll () {
                $this->time_query +=$this->object_time->finish();
            return $this;
    }
    
    //Функция формирования массива выполненных запросов и затраченного времени
    protected function addDataTime($sql) {
            $this->sqlDatatime[][$sql] = $this->object_time->finish();
         return $this;
    }
    
    //Функция получения количества запросов к БД
    public function getCountBD () {
        return $this->count_sql;
    }
    
    //Функция получения времени выполнения sql запросов
    public function getTimeQuery () {
        return $this->time_query;
    }
    
    //Функция получения массива всех запросов
    public function getArraySql () {
        return $this->sqlDatatime;
    }
}
