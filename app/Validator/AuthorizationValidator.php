<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\AuthorizationBuilder;

class AuthorizationValidator
{
    public static function validate(AuthorizationBuilder $authorizationBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getIntent())) {
                $validated = false;
                throw new BuildException('intent must be a string.');
            }
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getOvv())) {
                $validated = false;
                throw new BuildException('ovv must be a string ');
            }
            $getLastFourDigits = $authorizationBuilder->getLastFourDigits();
            if ($getLastFourDigits) {
                if (!RespectValidator::stringType()
                    ->length(4, 4)
                    ->validate($authorizationBuilder->getLastFourDigits())) {
                    $validated = false;
                    throw new BuildException('lastFourDigits must be a string of 4 characters');
                }
            }
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getMerchantData()
                ->getPaymentGatewayId())) {
                $validated = false;
                throw new BuildException('merchantData / paymentGatewayId must be a string.');
            }
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getMerchantData()
                ->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('merchantData / merchantNumber must be a string.');
            }
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getMerchantData()->getStoreNumber())) {
                $validated = false;
                throw new BuildException('merchantData / storeNumber must be a string.');
            }
            if (!RespectValidator::stringType()->validate($authorizationBuilder->getMerchantData()->getSource())) {
                $validated = false;
                throw new BuildException('merchantData / source must be a string.');
            }
            if (!RespectValidator::stringType()->length(1, 30)->validate($authorizationBuilder->getAccountNumber())) {
                $validated = false;
                throw new BuildException('accountNumber must be a string of at most 30 characters.');
            }
            if (!RespectValidator::stringType()->length(1, 36)->validate($authorizationBuilder->getTransactionId())) {
                $validated = false;
                throw new BuildException('transactionId must be a string of at most 36 characters.');
            }
            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
