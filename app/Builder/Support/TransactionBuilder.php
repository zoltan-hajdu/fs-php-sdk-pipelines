<?php
//define Transactions Builer class
namespace App\Builder\Support;

use App\Builder\Support\DetailsBuilder;

class TransactionBuilder
{
    private string $creditPlan;
    private array $details = array();
    private string $invoiceNumber;
    private float $total;
    private float $transactionAmount;
    private string $transactionDate;

    public function withCreditPlan(string $creditPlan): TransactionBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withDetails(DetailsBuilder $details): TransactionBuilder
    {
        $this->details[count($this->details)] = $details;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): TransactionBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function withTotal(float $total): TransactionBuilder
    {
        $this->total = $total;
        return $this;
    }

    public function withTransactionAmount(float $transactionAmount): TransactionBuilder
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    public function withTransactionDate(string $transactionDate): TransactionBuilder
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    public function getCreditPlan(): string
    {
        return $this->creditPlan;
    }

    public function getDetails(): array
    {
        return $this->details;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getTransactionAmount(): float
    {
        return $this->transactionAmount;
    }

    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }
}
