<?php

namespace App\Core;

use Exception;
use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Route;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Load a user's routes file.
     *
     * @param string $file
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get($uri, $controller)
    {
        $this->addRoute($uri, 'GET', $controller);
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post($uri, $controller)
    {
        $this->addRoute($uri, 'POST', $controller);
    }

    /**
     * Load the requested URI's associated controllers method.
     *
     * @param string $uri
     * @param string $requestType
     */
    public function direct($uri, $method)
    {
        $match  = $this->resolve($uri, $method);
        if($match) {
            return call_user_func_array(array(new $match->class, $match->method), $match->params);
        }
        throw new RouteNotFoundException('No route defined for this URI.');
    }

    protected function addRoute($uri, $method, $controller)
    {
        $route = new Route;
        $route->pattern = $uri;
        list($route->class, $route->method) = explode('@', $controller);
        $route->class = "App\\Controllers\\{$route->class}";
        $this->routes[$method][$uri] = $route;
    }

    protected function resolve($uri, $method)
    {
        $matched = false;
        foreach($this->routes[$method] as $route) {
            if (preg_match("#^{$route->pattern}/?$#", $uri, $route->params)) {
                $matched = true;
                break;
            }
        }

        //$route->params = array_slice($route->params, 1);
        array_shift($route->params);

        if(!$matched)
            throw new RouteNotFoundException('No route defined for this URI.');

        return $route;
    }
}
