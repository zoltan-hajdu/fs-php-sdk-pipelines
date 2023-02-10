<?php
//define GetPaymentPlanBuilder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\GetPaymentPlanRequest;
use App\Validator\GetPaymentPlanValidator;

class GetPaymentPlanBuilder extends BaseBuilder
{
    private string $amount;
    private string $merchant;
    private string $lang;
    private string $prov;

    public function build()
    {
        if (GetPaymentPlanValidator::validate($this)) {
            return new GetPaymentPlanRequest($this);
        }
    }

    public function withAmount(string $amount): GetPaymentPlanBuilder
    {
        $this->amount = $amount;
        return $this;
    }

    public function withMerchant(string $merchant): GetPaymentPlanBuilder
    {
        $this->merchant = $merchant;
        return $this;
    }

    public function withLang(string $lang): GetPaymentPlanBuilder
    {
        $this->lang = $lang;
        return $this;
    }

    public function withProv(string $prov): GetPaymentPlanBuilder
    {
        $this->prov = $prov;
        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getMerchant(): string
    {
        return $this->merchant;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function getProv(): string
    {
        return $this->prov;
    }
}
