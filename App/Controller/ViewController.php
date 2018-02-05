<?php

namespace App\Controller;


use App\Traits\ValidatorTrait;
use App\Vendor\Blade\Blade;
use Core\AbstractInterface\AbstractREST;

abstract class ViewController extends AbstractREST
{
    use ValidatorTrait;
    function View($tplName, $tplData = [])
    {
        $viewTemplate = Blade::getInstance()->render($tplName, $tplData);
        $this->response()->write($viewTemplate);
    }
}