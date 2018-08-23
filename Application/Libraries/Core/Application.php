<?php

namespace Libraries\Core;

use Libraries\Http\Request;
use Libraries\Http\Router;

class Application
{

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var \Libraries\Core\Controller
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var \Libraries\Http\Router
     */
    protected $router;

    /**
     * Application constructor
     * @param Router $router
     */
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
            System::log("No route matched to " . Request::getSiteUrl() . "/" . $this->getUrl(), __FILE__, System::E_NOTICE);

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
    public function getUrl(): string
    {
        $url = trim(Request::getRequestUrl(false), '/');
        return filter_var($url, FILTER_SANITIZE_URL);
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
     * Gets current controller instance
     * @return Controller|null
     */
    public function getController(): ?Controller
    {
        return $this->controller;
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
     * Return controller name
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName ?? '';
    }

    /**
     * @param string $prefix
     * @param string $suffix
     */
    protected function setControllerName(string $prefix = '', string $suffix = 'Controller')
    {
        $this->controllerName = $prefix . $this->router->getControllerName() . $suffix;
    }

    /**
     * Return controller method name
     * @return string
     */
    public function getActionName(): string
    {
        return $this->action ?? '';
    }

    /**
     * @param string $prefix
     * @param string $sufix
     */
    protected function setActionName(string $prefix = '', string $suffix = '')
    {
        $this->action = $prefix . $this->router->getActionName() . $suffix;
    }

    /**
     * Create controller and perform action
     */
    protected function runApplication()
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
                System::log("Method {$this->action} not exists in {$this->controllerName}", __FILE__);

                /**
                 * Method not exists in current controller
                 * load 404 error page
                 */
                $this->controller = new \Controllers\ErrorController();
                $this->controller->error404();
            }
        } else {
            System::log("Controller {$this->controllerName} not exists", __FILE__);

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
    protected function performAction()
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
            call_user_func([$this->controller, $this->action]);
        }

        $this->controller->after();
    }

}
