<?php
namespace App\Lib;

abstract class Controller
{
    protected $_request;
    protected $_response;

    public function __construct()
    {
        $this->_request = DI::get('request');
        $this->_response = DI::get('response');
    }

    public function initialize()
    {

    }
}
