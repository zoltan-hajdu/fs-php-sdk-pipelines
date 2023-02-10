<?php

namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Builder\Support\IdBuilder;
use App\Request\ZBlockRemovalRequest;
use App\Validator\ZBlockRemovalValidator;

class ZBlockRemovalBuilder extends BaseBuilder
{
    private string $customerId;
    private string $merchantNumber;
    private int $storeNumber;
    private string $blockCodeType;
    private IdBuilder $Id1;
    private IdBuilder $Id2;

    public function build()
    {
        if (ZBlockRemovalValidator::validate($this)) {
            return new ZBlockRemovalRequest($this);
        }
    }

    public function withcustomerId(string $customerId): ZBlockRemovalBuilder
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function withmerchantNumber(string $merchantNumber): ZBlockRemovalBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withstoreNumber(int $storeNumber): ZBlockRemovalBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withblockCodeType(string $blockCodeType): ZBlockRemovalBuilder
    {
        $this->blockCodeType = $blockCodeType;
        return $this;
    }

    public function withId1(IdBuilder $Id1): ZBlockRemovalBuilder
    {
        $this->Id1 = $Id1;
        return $this;
    }

    public function withId2(IdBuilder $Id2): ZBlockRemovalBuilder
    {
        $this->Id2 = $Id2;
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
}
