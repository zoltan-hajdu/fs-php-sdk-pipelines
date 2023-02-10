<?php
//define Return Request class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\ReturnRequest;
use App\Validator\ReturnRequestValidator;

class ReturnRequestBuilder extends BaseBuilder
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $creditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private string $authorizationCode;
    private string $salePerson;
    private string $transactionDate;

    public function build()
    {
        if (ReturnRequestValidator::validate($this)) {
            return new ReturnRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): ReturnRequestBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): ReturnRequestBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): ReturnRequestBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): ReturnRequestBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withCreditPlan(string $creditPlan): ReturnRequestBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withTransactionAmount(float $transactionAmount): ReturnRequestBuilder
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): ReturnRequestBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function withSalePerson(string $salePerson): ReturnRequestBuilder
    {
        $this->salePerson = $salePerson;
        return $this;
    }

    public function withTransactionType(string $transactionType): ReturnRequestBuilder
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function withAuthorizationCode(string $authorizationCode): ReturnRequestBuilder
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function withTransactionDate(string $transactionDate): ReturnRequestBuilder
    {
        $this->transactionDate = $transactionDate;
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

    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }
}
