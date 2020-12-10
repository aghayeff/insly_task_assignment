<?php

namespace App\Controllers;

use App\Lib\Controller;
use App\Lib\View;
use App\Repo\CalculationLogic;

class MainController extends Controller
{
    public function name()
    {
        return new View('name.php');
    }

    public function policyForm()
    {
        return new View('form.php');
    }

    public function calculate()
    {
        $logic = new CalculationLogic();

        echo $logic->calculate();
    }
}
