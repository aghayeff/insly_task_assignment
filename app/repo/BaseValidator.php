<?php

namespace App\Repo;

abstract class BaseValidator
{
    /**
     * required
     *
     * @param mixed $value
     * @return boolean
     */
    protected function required($value)
    {
        $val = trim($value);
        return $val == '' ? false : true;
    }


    /**
     * numeric
     *
     * @param int $value
     * @return boolean
     */
    protected function numeric($value)
    {
        return preg_match("/^([0-9]*)$/", $value) ? true : false;
    }


    /**
     * numeric
     *
     * @param float $value
     * @return boolean
     */
    protected function integer($value)
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) ? true : false;
    }


    /**
     * numeric
     *
     * @param int $value
     * @return boolean
     */
    protected function min($value, $minValue)
    {
        return $value < $minValue ? false : true;
    }


    /**
     * numeric
     *
     * @param int $value
     * @return boolean
     */
    protected function max($value, $maxValue)
    {
        return $value > $maxValue ? false : true;
    }
}