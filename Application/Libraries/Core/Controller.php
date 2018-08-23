<?php

namespace Libraries\Core;

use Controllers\ErrorController;
use Libraries\Http\Session;
use Libraries\Utilities\ClassUtils;

abstract class Controller
{

    /**
     * @var \Libraries\Core\Model|null
     */
    protected $model;

    /**
     * @var \Libraries\Core\View
     */
    protected $view;

    public function __construct()
    {
        /**
         * Start session
         */
        Session::init();

        /**
         * Create View object
         */
        $this->view = new View();

        /**
         * Try to load model for controller
         */
        $modelName = $this->getControllerShortName();
        $this->model = $this->loadModel($modelName);
    }


    /**
     * Performed before any actions
     */
    public function before()
    {
        if (!Session::userIsLoggedIn()) {
            /**
             * If user is not logged in render error 403 page
             */
            $errorController = new ErrorController();
            $errorController->error403();

            exit();
        }
    }

    /**
     * After action executing
     */
    public function after()
    {
        // Some operations
    }

    /**
     * Return model object
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * Return Model name based on current Controller name
     * @return string
     */
    protected function getControllerShortName(): string
    {
        try {
            $modelName = ClassUtils::getShortName($this);
            return str_replace('Controller', '', $modelName);
        } catch (\ReflectionException $ex) {
            return '';
        }
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

    /**
     * Create and return model instance
     * @param string $modelName
     * @return null|Model
     */
    public function loadModel(string $modelName): ?Model
    {
        if (file_exists($this->getModelPath($modelName))) {
            /**
             * Model was found,
             * create and return model
             */

            $modelName = '\\Models\\' . $modelName;
            return new $modelName();
        } else {
            System::log("Model {$modelName} not exists", __FILE__, System::E_WARNING);

            /**
             * Model does not exists
             */
            return null;
        }
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
     * Default controller action
     */
    public function view()
    {
        $this->getView()->render($this->getControllerShortName());
    }

}
