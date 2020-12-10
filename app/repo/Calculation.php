<?php

namespace App\Repo;

class Calculation
{
    private $formData;
    private $commissionPercent = 17;

    public $basePricePercent;
    public $basePrice;
    public $commission;
    public $tax;
    public $totalCost;
    public $instalments = [];
    public $instalment_count;

    public function __construct($formData)
    {
        $this->formData = $formData;
        $this->instalment_count = $formData['quantity'];
    }

    public function calculateForm() :void
    {
        $basePricePercent = new BasePericePercent($this->formData['userDay'], $this->formData['userTime']);

        //define base Price Percent by week days and time
        $this->basePricePercent = $basePricePercent::get();

        //calculate base price
        $this->getBasePrice();

        //calculate Commission
        $this->getCommission();

        //calculate Tax
        $this->getTax();

        //calculate Total Cost
        $this->getTotalCost();

        //calculate instalments
        $this->getInstalments();
    }

    public function getResult() :array
    {
        $result = [
            'row_titles' => [
                'value' => 'Value',
                'base_price' => 'Base Premium (' . $this->basePricePercent . '%)',
                'commission' => 'Commission (' . $this->commissionPercent . '%)',
                'tax' => 'Tax (' . $this->formData['tax'] . '%)',
                'total_cost' => '<b>Total Cost</b>'
            ],
            'policy' => [
                'value' => $this->formData['car_value'],
                'base_price' => $this->basePrice,
                'commission' => $this->commission,
                'tax' => $this->tax,
                'total_cost' => '<b>' . $this->totalCost . '</b>'
            ],
            'instalments_count' => $this->formData['quantity'],
            'instalments' => $this->instalments,
        ];

        return $result;
    }

    private function getInstalments() :void
    {
        if ($this->instalment_count > 1) {
            foreach (range(1, $this->instalment_count) as $count) {
                $this->instalments[] = [
                    'title' => '<b>' . $count . ' instalment</b>',
                    'base_price' => $this->divideEqually($this->basePrice, $this->instalment_count, $count),
                    'commission' => $this->divideEqually($this->commission, $this->instalment_count, $count),
                    'tax' => $this->divideEqually($this->tax, $this->instalment_count, $count),
                    'cost' => '<b>' . $this->divideEqually($this->totalCost, $this->instalment_count, $count) . '</b>',
                ];
            }
        }
    }

    private function getBasePrice() :void
    {
        $this->basePrice = $this->floatNumber($this->formData['car_value'] * $this->basePricePercent / 100);
    }

    private function getCommission() :void
    {
        $this->commission = $this->floatNumber($this->basePrice * $this->commissionPercent / 100);
    }

    private function getTax() :void
    {
        $this->tax = $this->floatNumber($this->basePrice * $this->formData['tax'] / 100);
    }

    private function getTotalCost() :void
    {
        $this->totalCost = $this->floatNumber($this->basePrice + $this->commission + $this->tax);
    }

    private function floatNumber($number)
    {
        return number_format($number, 2, '.', '');
    }

    private function divideEqually($dividedNumber, $dividingNumber, $count)
    {
        if ($count == $dividingNumber) {
            $firstDivide = $dividedNumber - $this->divideEqually($dividedNumber, $dividingNumber, 1) * ($count - 1);

            return $this->floatNumber($firstDivide);
        }

        return $this->floatNumber($dividedNumber / $dividingNumber);
    }

}