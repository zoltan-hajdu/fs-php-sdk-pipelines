<?php
//define VoidRequest Builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\VoidRequest;
use App\Validator\VoidRequestValidator;

class VoidRequestBuilder extends BaseBuilder
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
    private string $cancelType;

    public function build()
    {
        if (VoidRequestValidator::validate($this)) {
            return new VoidRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): VoidRequestBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): VoidRequestBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): VoidRequestBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): VoidRequestBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withCreditPlan(string $creditPlan): VoidRequestBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withTransactionAmount(float $transactionAmount): VoidRequestBuilder
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): VoidRequestBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function withSalePerson(string $salePerson): VoidRequestBuilder
    {
        $this->salePerson = $salePerson;
        return $this;
    }

    public function withTransactionType(string $transactionType): VoidRequestBuilder
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function withCancelType(string $cancelType): VoidRequestBuilder
    {
        $this->cancelType = $cancelType;
        return $this;
    }

    public function withAuthorizationCode(string $authorizationCode): VoidRequestBuilder
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function withtransactionDate(string $transactionDate): VoidRequestBuilder
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

    public function getCancelType(): string
    {
        return $this->cancelType;
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
