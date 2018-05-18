<?php

namespace Libraries\Core;

use Libraries\Http\Request;
use Libraries\Http\Router;

class Application
{

    protected $controllerName;
    protected $controller;
    protected $action;
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * Start application
     */
    public function init()
    {
        if ($this->router->match($this->getUrl())) {
            /**
             * Route matched, run application
             */
            $this->setControllerName();
            $this->setActionName();
            $this->runApplication();
        } else {
            /**
             * No route matched, load error page
             */
            $this->controller = new \Controllers\ErrorController();
            $this->controller->error404();
        }
    }

    /**
     * Get requested URL without query string
     * @return string
     */
    private function getUrl(): string
    {
        $url = trim(Request::getRequestUrl(false), '/');
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Set $controller
     * @param string $prefix
     * @param string $sufix
     */
    private function setControllerName(string $prefix = '', string $sufix = 'Controller')
    {
        $this->controllerName = $prefix . $this->router->getControllerName() . $sufix;
    }

    /**
     * Set $action
     * @param string $prefix
     * @param string $sufix
     */
    private function setActionName(string $prefix = '', string $sufix = '')
    {
        $this->action = $prefix . $this->router->getActionName() . $sufix;
    }
    
    /**
     * Return controller path
     * @return string
     */
    public function getControllerPath(): string
    {
        $path = System::getRootDir() . '/Application/Controllers/';
        $path .= str_replace('\\', '/', $this->controllerName) . '.php';

        return $path;
    }

    /**
     * Create controller and perform action
     */
    private function runApplication()
    {
        if (file_exists($this->getControllerPath())) {
            /**
             * Create controller
             */
            $this->controllerName = '\\Controllers\\' . $this->controllerName;
            $this->controller = new $this->controllerName();

            if (method_exists($this->controller, $this->action)) {
                $this->performAction();
            } else {
                /**
                 * Method not exists in current controller
                 * load 404 error page
                 */
                $this->controller = new \Controllers\ErrorController();
                $this->controller->error404();
            }
        } else {
            /**
             * Controller class not exists,
             * load 404 error page
             */
            $this->controller = new \Controllers\ErrorController();
            $this->controller->error404();
        }
    }
    
    /**
     * Execute action
     */
    private function performAction()
    {
        $this->controller->before();
        
        $params = $this->router->getParams(); 
        unset($params['controller'], $params['action']);

        if (!empty($params)) {
            /**
             * Call controller method with parameters
             */
            call_user_func_array([$this->controller, $this->action], $params);
        } else {
            /**
             * Call without parameters
             */
            $this->controller->{$this->action}();
        }
        
        $this->controller->after();
    }

    /**
     * Gets current controller instance
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }
    
    /**
     * Return router
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
    
    /**
     * Return controller name
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }
    
    /**
     * Return controller method name
     * @return string
     */
    public function getActionName(): string
    {
        return $this->action;
    }

}
