<?php

namespace Libraries\Core;

use Libraries\Http\Session;
use Smarty;
use Spipu\Html2Pdf\Html2Pdf;

class View
{

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
     * @param string $navigationController
     * @return bool
     */
    public static function checkForActiveController(string $navigationController): bool
    {
        $activeController = System::getApplication()->getRouter()->getControllerName();

        if ($activeController == $navigationController) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Checks if the passed string is the currently active controller action
     * @param string $navigationAction
     * @return bool
     */
    public static function checkForActiveAction(string $navigationAction): bool
    {
        $activeAction = System::getApplication()->getRouter()->getActionName();

        if ($activeAction == $navigationAction) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Checks if the passed string is the currently active controller and controller action
     * @param string $navControllerAndAction
     * @return bool
     */
    public static function checkForActive(string $navControllerAndAction): bool
    {
        $navControllerAndAction = explode("@", $navControllerAndAction);
        
        $activeController = System::getApplication()->getRouter()->getControllerName();
        $activeAction = System::getApplication()->getRouter()->getActionName();
        
        $navigationController = $navControllerAndAction[0];
        $navigationAction = $navControllerAndAction[1];
        
        if ($activeController == $navigationController && $activeAction == $navigationAction) {
            return true;
        }
        
        return false;
    }

    /**
     * Generate PDF file
     * @param string $fileName
     * @param string $view
     * @param array $data
     * @param bool $download
     */
    public function getPDF(string $fileName, string $view, array $data = [], bool $download = true)
    {
        $mode = $download ? 'D' : 'I';
        $html = $this->render($view, $data, false);
         
        $html2pdf = new Html2Pdf("P", "A4", "pl", true, "UTF-8", [19, 15, 19, 15]);
        $html2pdf->setDefaultFont("freesans");
        $html2pdf->writeHTML($html);
        $html2pdf->output($fileName . ".pdf", $mode);   
    }  
    
    /**
     * Display the output (smarty template)
     * @param string $view
     * @param array $data
     * @param bool $display
     * @return mixed
     */
    public function render(string $view, array $data = [], bool $display = true)
    {
        /**
         * Check if View file exists
         */
        if (!file_exists(System::getRootDir() . '/Application/Views/' . $view . 'View.tpl')) {
            die('View "' . $view . 'View" not found');
        }

        /**
         * Check for feedback
         */
        $feedbackPositive = Session::get('feedback_positive');
        $feedbackNegative = Session::get('feedback_negative');

        if (isset($feedbackPositive)) {
            $this->smarty->assign('feedback_positive', $feedbackPositive);
            Session::set('feedback_positive', null);
        } else {
            $this->smarty->assign('feedback_positive', '');
        }

        if (isset($feedbackNegative)) {
            $this->smarty->assign('feedback_negative', $feedbackNegative);
            Session::set('feedback_negative', null);
        } else {
            $this->smarty->assign('feedback_negative', '');
        }
        
        $this->smarty->assign('app_title', Config::get('APP_TITLE'));
        $this->smarty->assign('app_description', Config::get('APP_DESCRIPTION'));
        
        /**
         *  Assign variables
         */
        
        if ($data) {
            foreach ($data as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }

        if ($display) {
            // Displays a Smarty template
            $this->smarty->display($view . 'View.tpl');
        } else {
            // Fetches a rendered Smarty template
            return $this->smarty->fetch($view . 'View.tpl');
        }

        return true;
    }

}
