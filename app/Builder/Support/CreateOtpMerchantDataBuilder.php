<?php
//define MarchantData Builer class
namespace App\Builder\Support;

class CreateOtpMerchantDataBuilder
{
    private string $paymentGatewayId;
    private string $merchantNumber;
    private string $storeNumber;

    public function withPaymentGatewayId(string $paymentGatewayId): CreateOtpMerchantDataBuilder
    {
        $this->paymentGatewayId = $paymentGatewayId;
        return $this;
    }

    public function withMerchantNumber(string $merchantNumber): CreateOtpMerchantDataBuilder
    {
        $this->merchantNumber = $merchantNumber;
        return $this;
    }

    public function withStoreNumber(string $storeNumber): CreateOtpMerchantDataBuilder
    {
        $this->storeNumber = $storeNumber;
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
}
