<?php

namespace Core\Extensions;

class UsageMemory {
    
    static protected $memory;
    static protected $memory_peak;

    static public function start() {
        self::$memory = memory_get_usage();
    }
    
    static public function finish_memory () {
            self::$memory = (memory_get_usage() - self::$memory);
        return self::convert_memory(self::$memory);
    }   
    
    static public function finish_peak_memory () {
        return self::convert_memory(memory_get_peak_usage());
    }
    
    static private function convert_memory ($memory) {
        $i=0;
                while (floor($memory / 1024) >0)
                {
                    $i++;
                    $memory /=1024;
                }
            $name = array ('байт', 'КБ', 'МБ');
        return round($memory,2).' '. $name[$i];
    }
}
