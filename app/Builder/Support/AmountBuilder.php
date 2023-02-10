<?php
//define Amount Builer class
namespace App\Builder\Support;

class AmountBuilder
{
    private float $total;
    private string $currency;
    private array $details = array();
    private string $invoiceNumber;

    public function withTotal(float $total): AmountBuilder
    {
        $this->total = $total;
        return $this;
    }

    public function withCurrency(string $currency): AmountBuilder
    {
        $this->currency = $currency;
        return $this;
    }

    public function withDetails(array $details): AmountBuilder
    {
        $this->details = $details;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): AmountBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }
}
