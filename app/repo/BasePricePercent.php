<?php

namespace App\Repo;

class BasePricePercent
{
    private static $basePricePercent = 11;
    private $_time;
    private $_day;

    public function __construct($day, $time)
    {
        $this->_time = $time;
        $this->_day = $day;
        $this->rules();
    }

    public static function set($value)
    {
        return self::$basePricePercent = $value;
    }

    public static function get()
    {
        return self::$basePricePercent;
    }

    private function rules() :void
    {
        if ($this->_day == 5 && $this->_time >= 1500 && $this->_time <= 2000) {
            self::set(13);
        }
    }
}