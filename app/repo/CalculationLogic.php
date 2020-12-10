<?php

namespace App\Repo;

class CalculationLogic
{
    private $formData;
    private $outputClass;
    public $result = [];
    public $errors = [];

    public function __construct()
    {
        $this->formData = $this->getFormData();
        $this->outputClass = new JsonOutput();
    }

    public function calculate()
    {
        //validation
        $validation = new Validation($this->formData);
        $validation->validateForm();
        $this->errors = $validation->getErrors();

        if (empty($this->errors)) {
            //calculation
            $calculation = new Calculation($this->formData);
            $calculation->calculateForm();
            $this->result = $calculation->getResult();
        }

        return $this->output($this->result, $this->errors, $this->outputClass);
    }


    private function output($result, $errors, CalculationOutputInterface $formatter)
    {
        return $formatter->output($result, $errors);
    }

    private function getFormData()
    {
        $phpInput = file_get_contents('php://input');
        return json_decode($phpInput, true);
    }
}