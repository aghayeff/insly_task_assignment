<?php

use App\Lib\DI;
use App\Lib\ModuleLoader AS Loader;

$router = DI::get('router');
$response = DI::get('response');


$router->get(
    '/name',
    'MainController@name');

$router->get(
    '/insurance/policy',
    'MainController@policyForm');

$router->post(
    '/insurance/calculate',
    'MainController@calculate');

$router->get(
    '/employee/:id',
    'EmployeeController@getEmployee');