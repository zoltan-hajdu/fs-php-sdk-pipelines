<?php
//define Details Builer class
namespace App\Builder\Support;

class DetailsBuilder
{
    private ?string $itemNumber = null;
    private float $subTotal;

    public function withItemNumber(?string $itemNumber = null): DetailsBuilder
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    public function withSubTotal(float $subTotal): DetailsBuilder
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    public function getItemNumber()
    {
        if (isset($this->itemNumber)) {
            return $this->itemNumber;
        }
    }

    public function getSubTotal(): float
    {
        return $this->subTotal;
    }
}
