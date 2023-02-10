<?php
//define CustomerSearch Builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\CustomerSearchRequest;
use App\Validator\CustomerSearchValidator;

class CustomerSearchBuilder extends BaseBuilder
{
    private ?string $customerId = null;
    private string $merchantNumber;
    private string $storeNumber;
    //3.0 SDK
    private ?string $phoneNo = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $postalCode = null;

    public function build()
    {
        if (CustomerSearchValidator::validate($this)) {
            return new CustomerSearchRequest($this);
        }
    }

    public function withCustomerId(?string $customerId = null): CustomerSearchBuilder
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): CustomerSearchBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): CustomerSearchBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withphoneNo(?string $phoneNo = null): CustomerSearchBuilder
    {
        $this->phoneNo = $phoneNo;
        return $this;
    }

    public function withfirstName(?string $firstName = null): CustomerSearchBuilder
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function withlastName(?string $lastName = null): CustomerSearchBuilder
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function withpostalCode(?string $postalCode = null): CustomerSearchBuilder
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCustomerId()
    {
        if (isset($this->customerId)) {
            return $this->customerId;
        }
    }

    public function getMerchantNumber(): string
    {
        return $this->merchantNumber;
    }

    public function getStoreNumber(): string
    {
        return $this->storeNumber;
    }

    public function getphoneNo()
    {
        if (isset($this->phoneNo)) {
            return $this->phoneNo;
        }
    }

    public function getfirstName()
    {
        if (isset($this->firstName)) {
            return $this->firstName;
        }
    }

    public function getlastName()
    {
        if (isset($this->lastName)) {
            return $this->lastName;
        }
    }

    public function getpostalCode()
    {
        if (isset($this->postalCode)) {
            return $this->postalCode;
        }
    }
}
