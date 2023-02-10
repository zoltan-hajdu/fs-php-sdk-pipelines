<?php
//define InitiateCheckout builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\RedirectUrlsBuilder;
use App\Request\InitiateCheckoutRequest;
use App\Validator\InitiateCheckoutValidator;

class InitiateCheckoutBuilder extends BaseBuilder
{
    private float $totalAmount;
    private ?string $lastFourDigits = null;
    private RedirectUrlsBuilder $redirectUrls;
    private AddressBuilder $shippingAddress;
    private MerchantDataBuilder $merchantData;
    private CustomerDataBuilder $customerData;
    private string $currency;
    private int $creationTimeStamp;
    private AddressBuilder $billingAddress;
    private string $intent;
    private ?string $callbackUrl = null;
    private string $callbackKey;

    public function build()
    {
        if (InitiateCheckoutValidator::validate($this)) {
            return new InitiateCheckoutRequest($this);
        }
    }

    public function withTotalAmount(float $totalAmount): InitiateCheckoutBuilder
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function withLastFourDigits(?string $lastFourDigits = null): InitiateCheckoutBuilder
    {
        $this->lastFourDigits = $lastFourDigits;
        return $this;
    }

    public function withRedirectUrls(RedirectUrlsBuilder $redirectUrls): InitiateCheckoutBuilder
    {
        $this->redirectUrls = $redirectUrls;
        return $this;
    }

    public function withShippingAddress(AddressBuilder $shippingAddress): InitiateCheckoutBuilder
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function withMerchantData(MerchantDataBuilder $merchantData): InitiateCheckoutBuilder
    {
        $this->merchantData = $merchantData;
        return $this;
    }

    public function withCustomerData(CustomerDataBuilder $customerData): InitiateCheckoutBuilder
    {
        $this->customerData = $customerData;
        return $this;
    }

    public function withCurrency(string $currency): InitiateCheckoutBuilder
    {
        $this->currency = $currency;
        return $this;
    }

    public function withCreationTimeStamp(int $creationTimeStamp): InitiateCheckoutBuilder
    {
        $this->creationTimeStamp = $creationTimeStamp;
        return $this;
    }

    public function withBillingAddress(AddressBuilder $billingAddress): InitiateCheckoutBuilder
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function withIntent(string $intent): InitiateCheckoutBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function withCallbackUrl(?string $callbackUrl = null): InitiateCheckoutBuilder
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }

    public function withCallbackKey(string $callbackKey): InitiateCheckoutBuilder
    {
        $this->callbackKey = $callbackKey;
        return $this;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function getLastFourDigits()
    {
        if (isset($this->lastFourDigits)) {
            return $this->lastFourDigits;
        }
    }

    public function getRedirectUrls(): RedirectUrlsBuilder
    {
        return $this->redirectUrls;
    }

    public function getShippingAddress(): AddressBuilder
    {
        return $this->shippingAddress;
    }

    public function getMerchantData(): MerchantDataBuilder
    {
        return $this->merchantData;
    }

    public function getCustomerData(): CustomerDataBuilder
    {
        return $this->customerData;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCreationTimeStamp(): int
    {
        return $this->creationTimeStamp;
    }

    public function getBillingAddress(): AddressBuilder
    {
        return $this->billingAddress;
    }

    public function getIntent(): string
    {
        return $this->intent;
    }

    public function getCallbackUrl()
    {
        if (isset($this->callbackUrl)) {
            return $this->callbackUrl;
        }
    }

    public function getCallbackKey(): string
    {
        return $this->callbackKey;
    }
}
