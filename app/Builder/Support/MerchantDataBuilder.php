<?php
//define MarchantData Builer class
namespace App\Builder\Support;

class MerchantDataBuilder
{
    private string $paymentGatewayId;
    private string $merchantNumber;
    private string $storeNumber;
    private string $source;

    public function withPaymentGatewayId(string $paymentGatewayId): MerchantDataBuilder
    {
        $this->paymentGatewayId = $paymentGatewayId;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): MerchantDataBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): MerchantDataBuilder
    {
        $this->storeNumber = $storeNumber;
        return $this;
    }

    public function withSource(string $source): MerchantDataBuilder
    {
        $this->source = $source;
        return $this;
    }

    public function getPaymentGatewayId(): string
    {
        return $this->paymentGatewayId;
    }

    public function getMerchantNumber(): string
    {
        return $this->merchantNumber;
    }

    public function getStoreNumber(): string
    {
        return $this->storeNumber;
    }

    public function getSource(): string
    {
        return $this->source;
    }
}
