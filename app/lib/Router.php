<?php
namespace App\Lib;

class Router
{
    const ALLOWED_HTTP_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'OPTION'];

    private $routingTable = [];
    private $routeParams = [];

    private function validRoutingRule($uriSegments, $routingRule)
    {
        $diff = array_diff($uriSegments, $routingRule['uriSegments']);
        foreach($diff AS $n => $segment) {
            $uriSegment = isset($routingRule['uriSegments'][$n]) ? $routingRule['uriSegments'][$n] : null;
            if(is_null($uriSegment) || strpos($uriSegment, ':') === false) {
                
                return false;
            }
        }
        return true;
    }

    private function parseRoutingParams($uriSegments, $routingRule)
    {
        return array_values(array_diff($uriSegments, $routingRule['uriSegments']));
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if(!in_array($method, self::ALLOWED_HTTP_METHODS)) {
            DI::get('response')->notAllowed();
        }

        $uri = ltrim($_SERVER['REQUEST_URI'], '/');
        $uriSegments = explode('/', $uri);
        foreach($this->routingTable AS $routingRule) {
            if(!$this->validRoutingRule($uriSegments, $routingRule)) {
                continue;
            }
            $this->routeParams = $this->parseRoutingParams($uriSegments, $routingRule);

            foreach($routingRule['callables'] AS $callable) {
                if(is_string($callable)) {
                  list($controllerName, $methodName) = explode('@', $callable);
                  $controller = 'App\\Controllers\\'.$controllerName;
                  $controller = new $controller();
                  $controller->initialize();
                  call_user_func_array([$controller, $methodName], $this->routeParams);
                  continue;
                }

                if(is_callable($callable)) {
                    call_user_func_array($callable, $this->routeParams);
                }
            }
            return;
        }

        DI::get('response')->notFound();
    }

    public function __call($method, $args)
    {
        $method = strtoupper($method);
        $uri = ltrim($args[0], '/');
        $uriSegments = explode('/', $uri);
        $callables = array_slice($args, 1);
        if(
          in_array($method, self::ALLOWED_HTTP_METHODS)
          || $method === 'ROUTE'
        ) {
            $this->routingTable[] = compact('method', 'uri', 'uriSegments', 'callables');
        }
    }
}
