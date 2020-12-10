<?php
namespace App\Lib;

abstract class Model
{
    protected $_db;

    final public function __construct()
    {
        $this->_db = DI::get('db')->getConnection();
    }

    public function initialize()
    {

    }
}
