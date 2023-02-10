<?php
//define Autorization builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\AuthorizationRequest;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\TransactionBuilder;
use App\Builder\Support\CustomerId;
use App\Validator\AuthorizationValidator;

class AuthorizationBuilder extends BaseBuilder
{
    private string $transactionId;
    private string $intent;
    private string $ovv;
    private string $accountNumber;
    private MerchantDataBuilder $merchantData;
    private string $lastFourDigits;
    private TransactionBuilder $transaction;
    private string $description;
    //sdk 2.0
    private ?string $lookupType = null;
    private CustomerId $CustomerId;

    public function build()
    {
        if (AuthorizationValidator::validate($this)) {
            return new AuthorizationRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): AuthorizationBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withIntent(string $intent): AuthorizationBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function withOvv(string $ovv): AuthorizationBuilder
    {
        $this->ovv = $ovv;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): AuthorizationBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withMerchantData(MerchantDataBuilder $merchantData): AuthorizationBuilder
    {
        $this->merchantData = $merchantData;
        return $this;
    }

    public function withLastFourDigits(string $lastFourDigits): AuthorizationBuilder
    {
        $this->lastFourDigits = $lastFourDigits;
        return $this;
    }

    public function withTransaction(TransactionBuilder $transaction): AuthorizationBuilder
    {
        $this->transaction = $transaction;
        return $this;
    }

    public function withDescription(string $description): AuthorizationBuilder
    {
        $this->description = $description;
        return $this;
    }

    //SDK 2.0
    public function withlookupType(?string $lookupType = null): AuthorizationBuilder
    {
        $this->lookupType = $lookupType;
        return $this;
    }

    public function withCustomerId(CustomerId $CustomerId): AuthorizationBuilder
    {
        $this->CustomerId = $CustomerId;
        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getIntent(): string
    {
        return $this->intent;
    }

    public function getOvv(): string
    {
        return $this->ovv;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getMerchantData(): MerchantDataBuilder
    {
        return $this->merchantData;
    }

    public function getLastFourDigits()
    {
        if (isset($this->lastFourDigits)) {
            return $this->lastFourDigits;
        }
    }

    public function getTransaction(): TransactionBuilder
    {
        return $this->transaction;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getlookupType()
    {
        if (isset($this->lookupType)) {
            return $this->lookupType;
        }
    }

    public function getCustomerId()
    {
        if (isset($this->CustomerId)) {
            return $this->CustomerId;
        }
    }
}
