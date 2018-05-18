<?php

namespace Libraries\Http;

use Libraries\Core\System;

class Router
{

    protected $routes = [];
    protected $params = [];

    /**
     * Get all the routes from the routing table
     * @return type
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get the currently matched parameters
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Return matched route parameter specified by $key
     * @param string $key
     * @return string
     */
    public function getParam(string $key): string
    {
        return isset($this->params[$key]) ? $this->params[$key] : '';
    }

    /**
     * Add a route to the routing table
     * @param type $route
     * @param type $params
     */
    public function add(string $route, string $controllerName, string $actionName)
    {
        // Replace "/" to "\/"
        $route = preg_replace('/\//', '\\/', $route);
        
        // Convert variables e.g. {id}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        
        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route]['controller'] = $controllerName;
        $this->routes[$route]['action'] = $actionName;
    }

    /**
     * Match the route to the routes in the routing table
     * @param string $url
     * @return bool
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {

            if (preg_match($route, $url, $matches)) {

                $this->setParams($matches, $params);
                return true;
            }
        }

        return false;
    }

    /**
     * Add parameters to the $params table
     * @param array $matches
     */
    private function setParams(array $matches, array $params)
    {
        foreach ($matches as $key => $match) {
            if (is_string($key)) {
                $params[$key] = $match;
            }
        }

        $this->params = $params;
    }

    /**
     * Return controller name
     * @param bool $raw
     * @return type
     */
    public function getControllerName(bool $raw = false)
    {
        if (isset($this->params['controller'])) {

            if (!$raw) {
                $controller = $this->params['controller'];
                $controller = str_replace(' ', '\\', ucwords(str_replace('\\', ' ', $controller)));
            }

            return $controller;
        }

        return System::getDefaultController();
    }

    /**
     * Return action name
     * @return string
     */
    public function getActionName(): string
    {
        if (isset($this->params['action'])) {
            return lcfirst($this->params['action']);
        }

        return System::getDefaultAction();
    }

}
