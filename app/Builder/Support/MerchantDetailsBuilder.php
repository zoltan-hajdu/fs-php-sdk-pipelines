<?php
//define Details Builer class
namespace App\Builder\Support;

class MerchantDetailsBuilder
{
    private string $merchantNumber;
    private string $accountNumber;
    private ?string $lastFourDigits = null;
    private ?string $ovv = null;
    private string $authorizationCode;
    private string $creditPlan;
    private float $amount;
    private ?string $description = null;

    public function withMerchantNumber(string $merchantNumber): MerchantDetailsBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): MerchantDetailsBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withLastFourDigits(?string $lastFourDigits = null): MerchantDetailsBuilder
    {
        $this->lastFourDigits = $lastFourDigits;
        return $this;
    }

    public function withOvv(?string $ovv = null): MerchantDetailsBuilder
    {
        $this->ovv = $ovv;
        return $this;
    }

    public function withAuthorizationCode(string $authorizationCode): MerchantDetailsBuilder
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function withCreditPlan(string $creditPlan): MerchantDetailsBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withAmount(float $amount): MerchantDetailsBuilder
    {
        $this->amount = $amount;
        return $this;
    }

    public function withDescription(?string $description = null): MerchantDetailsBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function getMerchantNumber(): string
    {
        return $this->merchantNumber;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getLastFourDigits()
    {
        if (isset($this->lastFourDigits)) {
            return $this->lastFourDigits;
        }
    }

    public function getOvv()
    {
        if (isset($this->ovv)) {
            return $this->ovv;
        }
    }

    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    public function getCreditPlan(): string
    {
        return $this->creditPlan;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getDescription()
    {
        if (isset($this->description)) {
            return $this->description;
        }
    }
}
