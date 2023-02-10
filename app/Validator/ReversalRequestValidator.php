<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\ReversalRequestBuilder;

class ReversalRequestValidator
{
    public static function validate(ReversalRequestBuilder $reversalRequestBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->length(1, 36)->validate($reversalRequestBuilder->getTransactionId())) {
                $validated = false;
                throw new BuildException('transactionId must be a string of at most 30 characters');
            }
            if (!RespectValidator::stringType()
                ->length(19, 19)
                ->validate($reversalRequestBuilder->getAccountNumber())) {
                $validated = false;
                throw new BuildException('accountNumber must be a string of 30 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($reversalRequestBuilder->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(9, 9)->validate($reversalRequestBuilder->getStoreNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of 9 characters');
            }
            if (!RespectValidator::stringType()->length(1, 9)->validate($reversalRequestBuilder->getCreditPlan())) {
                $validated = false;
                throw new BuildException('creditPlan must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()
                ->length(4, 8)
                ->validate($reversalRequestBuilder->getTransactionType())) {
                $validated = false;
                throw new BuildException('transactionType must be a string between 4 to 6 characters');
            }
            if (!RespectValidator::floatVal()->positive()->validate($reversalRequestBuilder->getTransactionAmount())) {
                $validated = false;
                throw new BuildException('transactionAmount must be a float');
            }
            if (!RespectValidator::stringType()->length(1, 12)->validate($reversalRequestBuilder->getSalePerson())) {
                $validated = false;
                throw new BuildException('salePerson must be a string between 1 to 12 characters');
            }
            if (!RespectValidator::stringType()->validate($reversalRequestBuilder->getTransactionDate())) {
                $validated = false;
                throw new BuildException('transactionDate must be a string');
            }
            if (!RespectValidator::stringType()->length(4, 6)->validate($reversalRequestBuilder->getCancelType())) {
                $validated = false;
                throw new BuildException('cancelType must be a string between 4 to 6 characters');
            }

            $authdata = $reversalRequestBuilder->getauthorizationCode();

            if ($authdata && (!RespectValidator::stringType()
                    ->length(6, 6)
                    ->validate($reversalRequestBuilder->getauthorizationCode()))) {
                $validated = false;
                throw new BuildException('authorizationCode must be 6 characters');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
