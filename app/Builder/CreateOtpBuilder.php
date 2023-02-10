<?php
//define createOtp builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Builder\Support\CreateOtpMerchantDataBuilder;
use App\Request\CreateOtpRequest;
use App\Validator\CreateOtpValidator;

class CreateOtpBuilder extends BaseBuilder
{
    private CreateOtpMerchantDataBuilder $merchantData;
    private string $accountNumber;
    private int $phoneNumber;
    private string $salePerson;

    public function build()
    {
        if (CreateOtpValidator::validate($this)) {
            return new CreateOtpRequest($this);
        }
    }

    public function withmerchantData(CreateOtpMerchantDataBuilder $merchantData): CreateOtpBuilder
    {
        $this->merchantData = $merchantData;
        return $this;
    }

    public function withaccountNumber(string $accountNumber): CreateOtpBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withphoneNumber(int $phoneNumber): CreateOtpBuilder
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function withsalePerson(string $salePerson): CreateOtpBuilder
    {
        $this->salePerson = $salePerson;
        return $this;
    }

    public function getmerchantData(): CreateOtpMerchantDataBuilder
    {
        return $this->merchantData;
    }

    public function getaccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getphoneNumber(): int
    {
        return $this->phoneNumber;
    }

    public function getsalePerson(): string
    {
        return $this->salePerson;
    }
}
