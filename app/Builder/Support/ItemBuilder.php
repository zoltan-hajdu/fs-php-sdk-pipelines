<?php
//define Item Builer class
namespace App\Builder\Support;

class ItemBuilder
{
    private string $creditPlan;
    private float $subTotal;

    public function withItemBuilder(string $creditPlan, float $subTotal)
    {
        $this->creditPlan = $creditPlan;
        $this->subTotal = $subTotal;
        return $this;
    }


    public function getCreditPlan(): string
    {
        return $this->creditPlan;
    }

    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

}
