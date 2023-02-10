<?php
//define id Builer class
namespace App\Builder\Support;

class IdBuilder
{
    private ?string $issuerType = null;
    private ?string $idType = null;
    private ?string $provinceIssued = null;
    private ?string $expiryDate = null;
    private ?string $addressVerificationNeeded = null;
    private ?string $addressDifferentOnAccount = null;
    private ?string $idNumber = null;
    private ?string $companyInstituteName = null;
    private ?string $monthYearOfStatement = null;

    public function withissuerType(?string $issuerType = null): IdBuilder
    {
        $this->issuerType = $issuerType;
        return $this;
    }

    public function withidType(?string $idType = null): IdBuilder
    {
        $this->idType = $idType;
        return $this;
    }

    public function withprovinceIssued(?string $provinceIssued = null): IdBuilder
    {
        $this->provinceIssued = $provinceIssued;
        return $this;
    }

    public function withexpiryDate(?string $expiryDate = null): IdBuilder
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function withaddressVerificationNeeded(?string $addressVerificationNeeded = null): IdBuilder
    {
        $this->addressVerificationNeeded = $addressVerificationNeeded;
        return $this;
    }

    public function withaddressDifferentOnAccount(?string $addressDifferentOnAccount = null): IdBuilder
    {
        $this->addressDifferentOnAccount = $addressDifferentOnAccount;
        return $this;
    }

    public function withidNumber(?string $idNumber = null): IdBuilder
    {
        $this->idNumber = $idNumber;
        return $this;
    }

    public function withcompanyInstituteName($companyInstituteName): IdBuilder
    {
        $this->companyInstituteName = $companyInstituteName;
        return $this;
    }

    public function withmonthYearOfStatement($monthYearOfStatement): IdBuilder
    {
        $this->monthYearOfStatement = $monthYearOfStatement;
        return $this;
    }


    public function getissuerType(): string
    {
        return $this->issuerType;
    }

    public function getidType(): string
    {
        return $this->idType;
    }

    public function getprovinceIssued(): string
    {
        return $this->provinceIssued;
    }

    public function getexpiryDate()
    {
        if (isset($this->expiryDate)) {
            return $this->expiryDate;
        }
    }

    public function getaddressVerificationNeeded(): string
    {
        return $this->addressVerificationNeeded;
    }

    public function getaddressDifferentOnAccount()
    {
        if (isset($this->addressDifferentOnAccount)) {
            return $this->addressDifferentOnAccount;
        }
    }

    public function getidNumber(): string
    {
        return $this->idNumber;
    }

    public function getcompanyInstituteName()
    {
        if (isset($this->companyInstituteName)) {
            return $this->companyInstituteName;
        }
    }

    public function getmonthYearOfStatement()
    {
        if (isset($this->monthYearOfStatement)) {
            return $this->monthYearOfStatement;
        }
    }

}
