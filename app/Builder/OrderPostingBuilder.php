<?php
//define OrderPosting builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\OrderPostingRequest;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\AmountBuilder;
use App\Validator\OrderPostingValidator;

class OrderPostingBuilder extends BaseBuilder
{
    private string $intent;
    private string $callId;
    private string $orderMethod;
    private string $accountNumber;
    private MerchantDataBuilder $merchantData;
    private string $lastFourDigits;
    private CustomerDataBuilder $customerData;
    private int $creationTimeStamp;
    private array $transactions = array();
    private AddressBuilder $billingAddress;
    private AddressBuilder $shippingAddress;

    public function build()
    {
        if (OrderPostingValidator::validate($this)) {
            return new OrderPostingRequest($this);
        }
    }

    public function withCallId(string $callId): OrderPostingBuilder
    {
        $this->callId = $callId;
        return $this;
    }

    public function withLastFourDigits(string $lastFourDigits): OrderPostingBuilder
    {
        $this->lastFourDigits = $lastFourDigits;
        return $this;
    }

    public function withCustomerData(CustomerDataBuilder $customerData): OrderPostingBuilder
    {
        $this->customerData = $customerData;
        return $this;
    }

    public function withCreationTimeStamp(int $creationTimeStamp): OrderPostingBuilder
    {
        $this->creationTimeStamp = $creationTimeStamp;
        return $this;
    }

    public function withShippingAddress(AddressBuilder $shippingAddress): OrderPostingBuilder
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function withMerchantData(MerchantDataBuilder $merchantData): OrderPostingBuilder
    {
        $this->merchantData = $merchantData;
        return $this;
    }

    public function withBillingAddress(AddressBuilder $billingAddress): OrderPostingBuilder
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function withAccountNumber(string $accountNumber): OrderPostingBuilder
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function withTransactions(AmountBuilder $transaction): OrderPostingBuilder
    {
        $this->transactions[count($this->transactions)] = $transaction;
        return $this;
    }

    public function withIntent(string $intent): OrderPostingBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function withOrderMethod(string $orderMethod): OrderPostingBuilder
    {
        $this->orderMethod = $orderMethod;
        return $this;
    }

    public function getCallId(): string
    {
        return $this->callId;
    }

    public function getShippingAddress(): AddressBuilder
    {
        return $this->shippingAddress;
    }

    public function getMerchantData(): MerchantDataBuilder
    {
        return $this->merchantData;
    }

    public function getBillingAddress(): AddressBuilder
    {
        return $this->billingAddress;
    }

    public function getAccountNumber()
    {
        if (isset($this->accountNumber)) {
            return $this->accountNumber;
        }
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getIntent(): string
    {
        return $this->intent;
    }

    public function getOrderMethod(): string
    {
        return $this->orderMethod;
    }

    public function getLastFourDigits(): string
    {
        return $this->lastFourDigits;
    }

    public function getCustomerData(): CustomerDataBuilder
    {
        return $this->customerData;
    }

    public function getCreationTimeStamp(): int
    {
        return $this->creationTimeStamp;
    }
}
