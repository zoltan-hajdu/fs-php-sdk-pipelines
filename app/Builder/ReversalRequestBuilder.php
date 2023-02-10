<?php
//define ReversalRequestBuilder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\ReversalRequest;
use App\Validator\ReversalRequestValidator;

class ReversalRequestBuilder extends BaseBuilder
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $creditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private string $salePerson;
    private string $transactionDate;
    private string $cancelType;
    private string $authorizationCode;

    public function build()
    {
        if (ReversalRequestValidator::validate($this)) {
            return new ReversalRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): ReversalRequestBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): ReversalRequestBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): ReversalRequestBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): ReversalRequestBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withCreditPlan(string $creditPlan): ReversalRequestBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withTransactionAmount(float $transactionAmount): ReversalRequestBuilder
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): ReversalRequestBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function withSalePerson(string $salePerson): ReversalRequestBuilder
    {
        $this->salePerson = $salePerson;
        return $this;
    }

    public function withTransactionType(string $transactionType): ReversalRequestBuilder
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function withTransactionDate(string $transactionDate): ReversalRequestBuilder
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    public function withcancelType(string $cancelType): ReversalRequestBuilder
    {
        $this->cancelType = $cancelType;
        return $this;
    }

    public function withauthorizationCode(string $authorizationCode): ReversalRequestBuilder
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getMerchantNumber(): string
    {
        return $this->merchantNumber;
    }

    public function getStoreNumber(): string
    {
        return $this->storeNumber;
    }

    public function getCreditPlan(): string
    {
        return $this->creditPlan;
    }

    public function getTransactionAmount(): float
    {
        return $this->transactionAmount;
    }

    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getSalePerson(): string
    {
        return $this->salePerson;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getCancelType(): string
    {
        return $this->cancelType;
    }

    public function getauthorizationCode()
    {
        if (isset($this->authorizationCode)) {
            return $this->authorizationCode;
        }
    }
}
