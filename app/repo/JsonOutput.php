<?php

namespace App\Repo;

use App\Lib\DI;

class JsonOutput implements CalculationOutputInterface
{
    protected $_response;

    public function __construct()
    {
        $this->_response = DI::get('response');
    }

    public function output($data, $errors)
    {
        $data = [
            'data' => $data,
            'errors' => $errors,
            'code' => !empty($errors) ? array_key_exists('fatal', $errors) ? 500 : 422 : 200
        ];

        return $this->_response->json($data);
    }
}