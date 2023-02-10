<?php
//define Customer data Builer class
namespace App\Builder\Support;

class CustomerDataBuilder
{
    private string $customerFirstName;
    private ?string $customerEmail = null;
    private string $customerLastName;

    public function withCustomerFirstName(string $customerFirstName): CustomerDataBuilder
    {
        $this->customerFirstName = $customerFirstName;
        return $this;
    }

    public function withCustomerEmail(?string $customerEmail = null): CustomerDataBuilder
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function withCustomerLastName(string $customerLastName): CustomerDataBuilder
    {
        $this->customerLastName = $customerLastName;
        return $this;
    }

    public function getCustomerFirstName(): string
    {
        return $this->customerFirstName;
    }

    public function getCustomerEmail()
    {
        if (isset($this->customerEmail)) {
            return $this->customerEmail;
        }
    }

    public function getCustomerLastName(): string
    {
        return $this->customerLastName;
    }
}
