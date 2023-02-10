<?php
//define SaleRequestBuilder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\SaleRequest;
use App\Validator\SaleRequestValidator;

class SaleRequestBuilder extends BaseBuilder
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $creditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private ?string $authorizationCode = null;
    private string $salePerson;
    private string $transactionDate;
    private ?string $lookupType = null;
    private ?string $idType = null;
    private ?string $provinceOfIssue = null;
    private ?string $expiryDate = null;
    private ?string $addressDifferentFromAccount = null;
    private ?string $idNumber = null;
    private ?string $OTP = null;

    public function build()
    {
        if (SaleRequestValidator::validate($this)) {
            return new SaleRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): SaleRequestBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): SaleRequestBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): SaleRequestBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): SaleRequestBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withCreditPlan(string $creditPlan): SaleRequestBuilder
    {
        $this->creditPlan = $creditPlan;
        return $this;
    }

    public function withTransactionAmount(float $transactionAmount): SaleRequestBuilder
    {
        $this->transactionAmount = $transactionAmount;
        return $this;
    }

    public function withInvoiceNumber(string $invoiceNumber): SaleRequestBuilder
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    public function withAuthorizationCode(?string $authorizationCode = null): SaleRequestBuilder
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    public function withSalePerson(string $salePerson): SaleRequestBuilder
    {
        $this->salePerson = $salePerson;
        return $this;
    }

    public function withTransactionType(string $transactionType): SaleRequestBuilder
    {
        $this->transactionType = $transactionType;
        return $this;
    }

    public function withTransactionDate(string $transactionDate): SaleRequestBuilder
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }

    ///version 2.0
    public function withlookupType(?string $lookupType = null): SaleRequestBuilder
    {
        $this->lookupType = $lookupType;
        return $this;
    }

    public function withidType(?string $idType = null): SaleRequestBuilder
    {
        $this->idType = $idType;
        return $this;
    }

    public function withidNumber(?string $idNumber = null): SaleRequestBuilder
    {
        $this->idNumber = $idNumber;
        return $this;
    }

    public function withprovinceOfIssue(?string $provinceOfIssue = null): SaleRequestBuilder
    {
        $this->provinceOfIssue = $provinceOfIssue;
        return $this;
    }

    public function withexpiryDate(?string $expiryDate = null): SaleRequestBuilder
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function withaddressDifferentFromAccount(?string $addressDifferentFromAccount = null): SaleRequestBuilder
    {
        $this->addressDifferentFromAccount = $addressDifferentFromAccount;
        return $this;
    }

    //version 3.0
    public function withOTP(?string $OTP = null): SaleRequestBuilder
    {
        $this->OTP = $OTP;
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

    public function getauthorizationCode()
    {
        if (isset($this->authorizationCode)) {
            return $this->authorizationCode;
        }
    }

    public function getSalePerson(): string
    {
        return $this->salePerson;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getTransactionDate(): string
    {
        return $this->transactionDate;
    }

    ///SDK version 2.0
    public function getlookupType()
    {
        if (isset($this->lookupType)) {
            return $this->lookupType;
        }
    }

    public function getidType()
    {
        if (isset($this->idType)) {
            return $this->idType;
        }
    }

    public function getprovinceOfIssue()
    {
        if (isset($this->provinceOfIssue)) {
            return $this->provinceOfIssue;
        }
    }

    public function getexpiryDate()
    {
        if (isset($this->expiryDate)) {
            return $this->expiryDate;
        }
    }

    public function getaddressDifferentFromAccount()
    {
        if (isset($this->addressDifferentFromAccount)) {
            return $this->addressDifferentFromAccount;
        }
    }

    public function getidNumber()
    {
        if (isset($this->idNumber)) {
            return $this->idNumber;
        }
    }

//version 3.0
    public function getOTP()
    {
        if (isset($this->OTP)) {
            return $this->OTP;
        }
    }
}
