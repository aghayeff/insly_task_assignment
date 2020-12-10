<?php
require_once __DIR__.'/../vendor/autoload.php';

use App\Lib\DI;
use App\Lib\Config;
use App\Lib\DBConnection;
use App\Lib\Request;
use App\Lib\Response;
use App\Lib\Router;

DI::set('config', new Config());
DI::set('db', new DBConnection());
DI::set('router', new Router());
DI::set('request', new Request());
DI::set('response', new Response());

require 'routes.php';

DI::get('db')->connect(DI::get('config')->get('db'));

DI::get('router')->dispatch();

