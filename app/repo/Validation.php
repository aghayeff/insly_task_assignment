<?php

namespace App\Repo;

class Validation extends BaseValidator
{
    private $formData;
    private $fields = [];
    private $errors = [];

    public function __construct($formData)
    {
        $this->formData = $formData;
        $this->fields = array_keys($this->rules());
    }


    private function rules() :array
    {
        return [
            'car_value' =>  ['required', 'integer', 'min[100]', 'max[100000]'],
            'tax'       =>  ['required', 'integer', 'min[0]', 'max[100]'],
            'quantity'  =>  ['required', 'numeric', 'min[1]', 'max[12]'],
        ];
    }


    private function ruleMessages() :array
    {
        return [
            'car_value' =>  'Invalid Car Value',
            'tax'       =>  'Invalid Tax',
            'quantity'  =>  'Invalid Number of instalments',
        ];
    }


    public function validateForm() :void
    {
        if (!empty(array_diff_key(array_combine($this->fields, $this->fields), $this->formData))) {
            $this->addError('fatal', 'Fields are not defined correctly!');

            return;
        }

        foreach ($this->rules() as $key => $validations) {

            foreach ($validations as $rule) {

                $ruleName = $rule;
                $ruleArg = null;

                if (strpos($rule, '[') !== false) {
                    $explodedRule = explode('[', $rule,2);
                    $ruleName = $explodedRule[0];
                    $ruleArg = str_replace(']', '', $explodedRule[1]);
                }

                if (method_exists(get_parent_class($this), $ruleName)) {
                    $this->isValid($key, $ruleName, $ruleArg);
                } else {
                    $this->addError('fatal', "$ruleName is wrong validation name!");

                    return;
                }
            }
        }
    }


    private function isValid($ruleKey, $ruleName, $ruleArg) :void
    {
        //check validation from parent class
        $isValid = $this->{$ruleName}($this->formData[$ruleKey], $ruleArg);

        if (!$isValid) {
            $this->addError($ruleKey, $this->ruleMessages()[$ruleKey]);
        }
    }


    private function addError($key, $val) :void
    {
        $this->errors[$key] = $val;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}