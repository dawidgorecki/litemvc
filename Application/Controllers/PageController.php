<?php

namespace Controllers;

use Libraries\Core\Controller;

class PageController extends Controller
{

    /**
     * Pricing page
     */
    public function pricing()
    {
        $this->getView()->render('Pricing');
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $this->getView()->render('Checkout');
    }

}
