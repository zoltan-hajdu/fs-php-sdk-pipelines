<?php
//define Customer data Builer class
namespace App\Builder\Support;

class AddressBuilder
{
    private string $personName;
    private string $firstName;
    private string $lastName;
    private string $line1;
    private string $city;
    private string $stateProvinceCode;
    private string $postalCode;
    private string $countryCode;

    public function withPersonName(string $personName = null): AddressBuilder
    {
        $this->personName = $personName;
        return $this;
    }

    public function withFirstName(string $firstName): AddressBuilder
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function withLastName(string $lastName): AddressBuilder
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function withLine1(string $line1): AddressBuilder
    {
        $this->line1 = $line1;
        return $this;
    }

    public function withCity(string $city): AddressBuilder
    {
        $this->city = $city;
        return $this;
    }

    public function withStateProvinceCode(string $stateProvinceCode): AddressBuilder
    {
        $this->stateProvinceCode = $stateProvinceCode;
        return $this;
    }

    public function withPostalCode(string $postalCode): AddressBuilder
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function withCountryCode(string $countryCode): AddressBuilder
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getPersonName(): string
    {
        return $this->personName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStateProvinceCode(): string
    {
        return $this->stateProvinceCode;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
