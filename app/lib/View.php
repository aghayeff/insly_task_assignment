<?php

namespace App\Lib;

class View
{
    public function __construct($tpl)
    {
        include '../app/resources/views/'.$tpl;
    }
}