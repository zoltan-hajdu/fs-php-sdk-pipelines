<?php
//define GetidTypelistBuilder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\GetidTypelistRequest;
use App\Validator\GetidTypelistValidator;

class GetidTypelistBuilder extends BaseBuilder
{
    private ?string $issuerType = null;
    private string $customerProvince;

    public function build()
    {
        if (GetidTypelistValidator::validate($this)) {
            return new GetidTypelistRequest($this);
        }
    }

    public function withissuerType(?string $issuerType = null): GetidTypelistBuilder
    {
        $this->issuerType = $issuerType;
        return $this;
    }

    public function withcustomerProvince(string $customerProvince): GetidTypelistBuilder
    {
        $this->customerProvince = $customerProvince;
        return $this;
    }

    public function getissuerType()
    {
        if (isset($this->issuerType)) {
            return $this->issuerType;
        }
    }

    public function getcustomerProvince(): string
    {
        return $this->customerProvince;
    }
}
