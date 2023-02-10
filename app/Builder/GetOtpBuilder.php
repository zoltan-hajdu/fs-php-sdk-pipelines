<?php

namespace App\Builder;

use App\Request\GetOtpRequest;
use App\Validator\GetOtpValidator;

class GetOtpBuilder extends BaseBuilder
{
    private string $accountNumber;
    private int $phoneNumber;

    public function build()
    {
        if (GetOtpValidator::validate($this)) {
            return new GetOtpRequest($this);
        }
    }

    public function withAccountNumber(string $accountNumber): GetOtpBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withPhoneNumber(int $phoneNumber): GetOtpBuilder
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }
}
