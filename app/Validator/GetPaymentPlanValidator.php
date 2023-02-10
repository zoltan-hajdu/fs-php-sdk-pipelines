<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\GetPaymentPlanBuilder;

class GetPaymentPlanValidator
{
    public static function validate(GetPaymentPlanBuilder $getPaymentPlanBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->validate($getPaymentPlanBuilder->getAmount())) {
                $validated = false;
                throw new BuildException('amount must be a string');
            }
            if (!RespectValidator::stringType()->validate($getPaymentPlanBuilder->getMerchant())) {
                $validated = false;
                throw new BuildException('merchant must be a string');
            }
            if (!RespectValidator::stringType()->validate($getPaymentPlanBuilder->getLang())) {
                $validated = false;
                throw new BuildException('lang must be a string');
            }
            if (!RespectValidator::stringType()->validate($getPaymentPlanBuilder->getProv())) {
                $validated = false;
                throw new BuildException('prov must be a string');
            }
            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
