<?php
namespace App\Lib;

class Request
{
    private $params, $query, $form, $body;

    public function __construct()
    {
        $this->params = DI::get('router')->getRouteParams();
        $this->query = $_GET;
        $this->post = $_POST;
        $this->body = file_get_contents('php://input');
        if(
            isset($_SERVER['CONTENT_TYPE'])
            &&
            $_SERVER['CONTENT_TYPE'] === 'application/json'
        ) {
            $this->body = json_decode($this->body, true);
        }
    }

    public function params()
    {
        return $this->params;
    }

    public function param($key)
    {
        return $this->params[$key];
    }

    public function query()
    {
        return $this->query;
    }

    public function queryValue($key)
    {
        return $this->query[$key];
    }

    public function post()
    {
        return $this->post;
    }

    public function postValue($key)
    {
        return $this->post[$key];
    }

    public function body()
    {
        return $this->body;
    }

    public function bodyValue($key)
    {
        return $this->body[$key];
    }
}
