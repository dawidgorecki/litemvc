<?php

namespace Libraries\Core;

use Libraries\Http\Session;
use ReflectionClass;

class Controller
{
        
    protected $model;
    protected $view; 
    
    public function __construct()
    {
        /**
         * Start session
         */
        Session::init();
        
        /**
         * Create model and view objects for controller
         */
        $modelName = $this->getModelShortName();
        
        $this->model = $this->loadModel($modelName);
        $this->view = new View();
    }
    
    /**
     * Performed before any actions
     */
    public function before()
    {
        // e.g. checking authentication
    }
    
    /**
     * After action executing
     */
    public function after()
    {
        
    }
    
    /**
     * Return model object
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
    
    /**
     * Return view object
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }
    
    /**
     * Create and return model instance
     * @param string $model
     * @return Model
     */
    public function loadModel(string $modelName)
    {
        if (file_exists($this->getModelPath($modelName))) {
            /**
             * Model was found,
             * create and return model
             */
            
            $modelName = '\\Models\\' . $modelName;
            return new $modelName();
        } else {
            /**
             * Model does not exists
             */
            return null;
        }
    }

    /**
     * Default controller action
     */
    public function view()
    {
        $this->getView()->render($this->getModelShortName());
    }
    
    /**
     * Return Model name based on current Controller name
     * @return string
     */
    protected function getModelShortName(): string
    {
        $controllerShortName = (new ReflectionClass($this))->getShortName();
        return str_replace('Controller', '', $controllerShortName);    
    }
    
    /**
     * Return model path
     * @param string $model
     * @return string
     */
    protected function getModelPath(string $modelName): string
    {
        $path = System::getRootDir() . '/Application/Models/';
        $path .= str_replace('\\', '/', $modelName) . '.php';

        return $path;
    }

}
