<?php

namespace Controller\Home; 

use Service\ViewRenderer;
use Controller\Rv\ControllerInterface;

class ControllerHome implements ControllerInterface
{
    public function handle()
    {
        $view = new ViewRenderer();
        $view->render('viewDonoDeArea');
    }
}