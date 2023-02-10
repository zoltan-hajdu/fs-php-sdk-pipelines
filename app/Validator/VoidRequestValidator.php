<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\VoidRequestBuilder;

class VoidRequestValidator
{
    public static function validate(VoidRequestBuilder $voidRequestBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->length(1, 36)->validate($voidRequestBuilder->getTransactionId())) {
                $validated = false;
                throw new BuildException('transactionId must be a string of at most 30 characters');
            }
            if (!RespectValidator::stringType()->length(19, 19)->validate($voidRequestBuilder->getAccountNumber())) {
                $validated = false;
                throw new BuildException('accountNumber must be a string of 30 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($voidRequestBuilder->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(9, 9)->validate($voidRequestBuilder->getStoreNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of 9 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($voidRequestBuilder->getCreditPlan())) {
                $validated = false;
                throw new BuildException('creditPlan must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(4, 6)->validate($voidRequestBuilder->getTransactionType())) {
                $validated = false;
                throw new BuildException('transactionType must be a string between 4 to 6 characters');
            }
            if (!RespectValidator::floatVal()->positive()->validate($voidRequestBuilder->getTransactionAmount())) {
                $validated = false;
                throw new BuildException('transactionAmount must be a float');
            }
            if (!RespectValidator::stringType()->length(1, 15)->validate($voidRequestBuilder->getInvoiceNumber())) {
                $validated = false;
                throw new BuildException('invoiceNumber must be a string between 1 to 15 characters');
            }
            if (!RespectValidator::stringType()->length(1, 12)->validate($voidRequestBuilder->getSalePerson())) {
                $validated = false;
                throw new BuildException('salePerson must be a string between 1 to 12 characters');
            }
            if (!RespectValidator::stringType()->validate($voidRequestBuilder->getTransactionDate())) {
                $validated = false;
                throw new BuildException('transactionDate must be a string');
            }
            if (!RespectValidator::stringType()->length(6, 6)->validate($voidRequestBuilder->getAuthorizationCode())) {
                $validated = false;
                throw new BuildException('authorizationCode must be a string of 6 characters');
            }
            if (!RespectValidator::stringType()->length(4, 6)->validate($voidRequestBuilder->getCancelType())) {
                $validated = false;
                throw new BuildException('cancelType must be a string between 4 to 6 characters');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
