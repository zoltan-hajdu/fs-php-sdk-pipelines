<?php
//define CustomerId class
namespace App\Builder\Support;

class CustomerId
{
    private string $idType;
    private string $idNumber;
    private ?string $provinceOfIssue = null;
    private ?string $expiryDate = null;
    private ?string $addressDifferentFromAccount = null;

    ///version 2.0

    public function withidType(string $idType): CustomerId
    {
        $this->idType = $idType;
        return $this;
    }

    public function withidNumber(string $idNumber): CustomerId
    {
        $this->idNumber = $idNumber;
        return $this;
    }

    public function withprovinceOfIssue(?string $provinceOfIssue = null): CustomerId
    {
        $this->provinceOfIssue = $provinceOfIssue;
        return $this;
    }

    public function withexpiryDate(?string $expiryDate = null): CustomerId
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function withaddressDifferentFromAccount(?string $addressDifferentFromAccount = null): CustomerId
    {
        $this->addressDifferentFromAccount = $addressDifferentFromAccount;
        return $this;
    }

    ///SDK version 2.0

    public function getidType(): string
    {
        return $this->idType;
    }

    public function getidNumber(): string
    {
        return $this->idNumber;
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
}
