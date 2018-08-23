<?php

namespace Libraries\Core;

use Libraries\Http\Session;
use Smarty;
use Spipu\Html2Pdf\Html2Pdf;

class View
{

    /**
     * @var Smarty
     */
    protected $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->addTemplateDir(Config::get('PATH_SMARTY_TEMPLATES'));
        $this->smarty->setCacheDir(Config::get('PATH_SMARTY_CACHE'));
        $this->smarty->setCompileDir(Config::get('PATH_SMARTY_COMPILE'));
    }

    /**
     * Checks if the passed string is the currently active controller
     * @param string $controllerName
     * @return bool
     */
    public static function checkForActiveController(string $controllerName): bool
    {
        $activeController = System::getApplication()->getRouter()->getControllerName();

        if ($activeController == $controllerName) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the passed string is the currently active controller action
     * @param string $actionName
     * @return bool
     */
    public static function checkForActiveAction(string $actionName): bool
    {
        $activeAction = System::getApplication()->getRouter()->getActionName();

        if ($activeAction == $actionName) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the passed string is the currently active controller@action e.g. Page@view
     * @param string $controllerAndAction
     * @return bool
     */
    public static function checkForActive(string $controllerAndAction): bool
    {
        $controllerAndAction = explode("@", $controllerAndAction);
        return (self::checkForActiveController($controllerAndAction[0]) && self::checkForActiveAction($controllerAndAction[1]));
    }

    /**
     * Check for feedback
     */
    protected function checkFeedback()
    {
        $this->smarty->assign('feedback_positive', Session::get('feedback_positive'));
        $this->smarty->assign('feedback_negative', Session::get('feedback_negative'));

        Session::delete(['feedback_positive', 'feedback_negative']);
    }

    /**
     * @param array $data
     */
    protected function setViewParams(array $data)
    {
        $this->checkFeedback();
        $this->smarty->assign('app_title', Config::get('APP_TITLE'));
        $this->smarty->assign('app_description', Config::get('APP_DESCRIPTION'));
        $this->smarty->assign('app_lang', Config::get('APP_LANG'));

        /**
         *  Assign variables
         */
        if ($data) {
            foreach ($data as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }
    }

    /**
     * Display or return the output (smarty template)
     * @param string $pathToView
     * @param array $data
     * @param bool $display
     * @return mixed
     */
    public function render(string $pathToView, array $data = [], bool $display = true)
    {
        /**
         * Check if View file exists
         */
        if (!file_exists(System::getRootDir() . '/Application/Views/' . $pathToView . 'View.tpl')) {
            System::log("View {$pathToView} not found", __FILE__);

            /**
             * View not found
             * load 404 error page
             */
            $error = new \Controllers\ErrorController();
            $error->error404();

            exit();
        }

        $this->setViewParams($data);

        try {
            if ($display) {
                $this->smarty->display($pathToView . 'View.tpl');
            } else {
                return $this->smarty->fetch($pathToView . 'View.tpl');
            }
        } catch (\Exception $e) {
            System::log("Cannot render view {$pathToView}", __FILE__);
            $error = new \Controllers\ErrorController();
            $error->error500();

            exit();
        }

        return true;
    }

    /**
     * Generate PDF file
     * @param string $fileName
     * @param string $pathToView
     * @param array $data
     * @param bool $download
     */
    public function getPDF(string $fileName, string $pathToView, array $data = [], bool $download = true)
    {
        $mode = $download ? 'D' : 'I';
        $html = $this->render($pathToView, $data, false);

        $html2pdf = new Html2Pdf("P", "A4", "pl", true, "UTF-8", [19, 15, 19, 15]);
        $html2pdf->setDefaultFont("freesans");
        $html2pdf->writeHTML($html);

        try {
            $html2pdf->output($fileName . ".pdf", $mode);
        } catch (\Exception $e) {
            System::log("Cannot render PDF from view {$pathToView}", __FILE__);
            $error = new \Controllers\ErrorController();
            $error->error500();

            exit();
        }
    }

}
