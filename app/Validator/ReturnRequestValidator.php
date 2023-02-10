<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\ReturnRequestBuilder;

class ReturnRequestValidator
{
    public static function validate(ReturnRequestBuilder $returnRequestBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->length(1, 36)->validate($returnRequestBuilder->getTransactionId())) {
                $validated = false;
                throw new BuildException('transactionId must be a string of at most 30 characters');
            }
            if (!RespectValidator::stringType()->length(19, 19)->validate($returnRequestBuilder->getAccountNumber())) {
                $validated = false;
                throw new BuildException('accountNumber must be a string of 30 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($returnRequestBuilder->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(9, 9)->validate($returnRequestBuilder->getStoreNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of 9 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($returnRequestBuilder->getCreditPlan())) {
                $validated = false;
                throw new BuildException('creditPlan must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(4, 6)->validate($returnRequestBuilder->getTransactionType())) {
                $validated = false;
                throw new BuildException('transactionType must be a string between 4 to 6 characters');
            }
            if (!RespectValidator::floatVal()->positive()->validate($returnRequestBuilder->getTransactionAmount())) {
                $validated = false;
                throw new BuildException('transactionAmount must be a float');
            }
            if (!RespectValidator::stringType()->length(1, 15)->validate($returnRequestBuilder->getInvoiceNumber())) {
                $validated = false;
                throw new BuildException('invoiceNumber must be a string between 1 to 15 characters');
            }
            if (!RespectValidator::stringType()
                ->length(6, 6)
                ->validate($returnRequestBuilder->getAuthorizationCode())) {
                $validated = false;
                throw new BuildException('authorizationCode must be a string between 6 characters');
            }
            if (!RespectValidator::stringType()->length(1, 12)->validate($returnRequestBuilder->getSalePerson())) {
                $validated = false;
                throw new BuildException('salePerson must be a string between 1 to 12 characters');
            }
            if (!RespectValidator::stringType()->validate($returnRequestBuilder->getTransactionDate())) {
                $validated = false;
                throw new BuildException('transactionDate must be a string');
            }
            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
