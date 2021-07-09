<?php

namespace Wifi;

class TimePage {
    static private $start =0;
    static private $memory = 0;
    
    static public function start () {
        self::$start    = microtime(true);
        self::$memory   = memory_get_usage();
    }
    
    static public function finish_time () {
        return round((microtime(true) - self::$start),4)."сек";
    }
    
    static public function finish_memory () {
        self::$memory = (memory_get_usage() - self::$memory);
                $i=0;
                while (floor(self::$memory / 1024) >0)
                {
                    $i++;
                    self::$memory /=1024;
                }
            $name = array ('байт', 'КБ', 'МБ');
        return round(self::$memory,2).' '. $name[$i];
    }
}
