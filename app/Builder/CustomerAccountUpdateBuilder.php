<?php
//define customer account update builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Builder\Support\IdBuilder;
use App\Request\CustomerAccountUpdateRequest;
use App\Validator\CustomerAccountUpdateValidator;

class CustomerAccountUpdateBuilder extends BaseBuilder
{
    private string $customerId;
    private string $merchantNumber;
    private int $storeNumber;
    private string $blockCodeType;
    private IdBuilder $Id1;
    private IdBuilder $Id2;
    private IdBuilder $Id3;

    public function build()
    {
        if (CustomerAccountUpdateValidator::validate($this)) {
            return new CustomerAccountUpdateRequest($this);
        }
    }

    public function withcustomerId(string $customerId): CustomerAccountUpdateBuilder
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function withmerchantNumber(string $merchantNumber): CustomerAccountUpdateBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withstoreNumber(int $storeNumber): CustomerAccountUpdateBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withblockCodeType(string $blockCodeType): CustomerAccountUpdateBuilder
    {
        $this->blockCodeType = $blockCodeType;
        return $this;
    }

    public function withId1(IdBuilder $Id1): CustomerAccountUpdateBuilder
    {
        $this->Id1 = $Id1;
        return $this;
    }

    public function withId2(IdBuilder $Id2): CustomerAccountUpdateBuilder
    {
        $this->Id2 = $Id2;
        return $this;
    }

    public function withId3(IdBuilder $Id3): CustomerAccountUpdateBuilder
    {
        $this->Id3 = $Id3;
        return $this;
    }

    public function getcustomerId(): string
    {
        return $this->customerId;
    }

    public function getmerchantNumber(): string
    {
        return $this->merchantNumber;
    }

    public function getstoreNumber(): int
    {
        return $this->storeNumber;
    }

    public function getblockCodeType(): string
    {
        return $this->blockCodeType;
    }

    public function getId1(): IdBuilder
    {
        return $this->Id1;
    }

    public function getId2(): IdBuilder
    {
        return $this->Id2;
    }

    public function getId3()
    {
        if (isset($this->Id3)) {
            return $this->Id3;
        }
    }
}
