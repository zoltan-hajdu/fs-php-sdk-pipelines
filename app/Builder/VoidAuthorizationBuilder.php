<?php
//define VoidAuthorization builder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\VoidAuthorizationRequest;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\MerchantDetailsBuilder;
use App\Validator\VoidAuthorizationValidator;

class VoidAuthorizationBuilder extends BaseBuilder
{
    private string $transactionId;
    private string $intent;
    private MerchantDataBuilder $merchantData;
    private MerchantDetailsBuilder $details;

    public function build()
    {
        if (VoidAuthorizationValidator::validate($this)) {
            return new VoidAuthorizationRequest($this);
        }
    }

    public function withTransactionId(string $transactionId): VoidAuthorizationBuilder
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function withIntent(string $intent): VoidAuthorizationBuilder
    {
        $this->intent = $intent;
        return $this;
    }

    public function withMerchantData(MerchantDataBuilder $merchantData): VoidAuthorizationBuilder
    {
        $this->merchantData = $merchantData;
        return $this;
    }

    public function withDetails(MerchantDetailsBuilder $details): VoidAuthorizationBuilder
    {
        $this->details = $details;
        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getIntent(): string
    {
        return $this->intent;
    }

    public function getMerchantData(): MerchantDataBuilder
    {
        return $this->merchantData;
    }

    public function getDetails(): MerchantDetailsBuilder
    {
        return $this->details;
    }
}
