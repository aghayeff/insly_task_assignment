<?php

namespace App\Repo;

interface CalculationOutputInterface
{
    public function output($data, $errors);
}