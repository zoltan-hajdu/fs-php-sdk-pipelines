<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\SaleRequestBuilder;

class SaleRequestValidator
{
    public static function validate(SaleRequestBuilder $saleRequestBuilder): bool
    {
        try {

            $validated = true;
            $salesvalidate = RespectValidator::stringType();
            switch (!$salesvalidate) {
                case RespectValidator::stringType()->length(1, 36)->validate($saleRequestBuilder->getTransactionId()):
                    $validated = false;
                    throw new BuildException('transactionId must be a string of at most 36 characters');
                    break;
                case RespectValidator::stringType()->length(19, 19)->validate($saleRequestBuilder->getAccountNumber()):
                    $validated = false;
                    throw new BuildException('accountNumber must be a string of 19 characters');
                    break;
                case RespectValidator::stringType()->length(1, 9)->validate($saleRequestBuilder->getMerchantNumber()):
                    $validated = false;
                    throw new BuildException('merchantNumber must be a string of at most 9 characters');
                    break;
                case RespectValidator::stringType()->length(9, 9)->validate($saleRequestBuilder->getStoreNumber()):
                    $validated = false;
                    throw new BuildException('StoreNumber must be a string of 9 characters');
                    break;
                case RespectValidator::stringType()->length(1, 9)->validate($saleRequestBuilder->getCreditPlan()):
                    $validated = false;
                    throw new BuildException('creditPlan must be a string of at most 9 characters');
                    break;
                case RespectValidator::stringType()->length(4, 6)->validate($saleRequestBuilder->getTransactionType()):
                    $validated = false;
                    throw new BuildException('transactionType must be a string between 4 to 6 characters');
                    break;
                case RespectValidator::floatVal()->positive()->validate($saleRequestBuilder->getTransactionAmount()):
                    $validated = false;
                    throw new BuildException('transactionAmount must be a float');
                    break;
                case RespectValidator::stringType()->length(1, 15)->validate($saleRequestBuilder->getInvoiceNumber()):
                    $validated = false;
                    throw new BuildException('invoiceNumber must be a string between 1 to 15 characters');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType()->length(6, 6))
                    ->validate($saleRequestBuilder->getauthorizationCode()):
                    $validated = false;
                    throw new BuildException('authorizationCode must be  6 characters');
                    break;
                case RespectValidator::stringType()->length(1, 12)->validate($saleRequestBuilder->getSalePerson()):
                    $validated = false;
                    throw new BuildException('salePerson must be a string between 1 to 12 characters');
                    break;
                case RespectValidator::stringType()->validate($saleRequestBuilder->getTransactionDate()):
                    $validated = false;
                    throw new BuildException('transactionDate must be a string');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(1, 24))
                    ->validate($saleRequestBuilder->getidType()):
                    $validated = false;
                    throw new BuildException('IdType must be a string between 1 to 24 characters');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(2, 2))
                    ->validate($saleRequestBuilder->getprovinceOfIssue()):
                    $validated = false;
                    throw new BuildException('ProvinceOfIssue be a string and 2 characters');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(5, 5))
                    ->validate($saleRequestBuilder->getexpiryDate()):
                    $validated = false;
                    throw new BuildException('ExpiryDate be a string and 5 characters');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(1, 1))
                    ->validate($saleRequestBuilder->getaddressDifferentFromAccount()):
                    $validated = false;
                    throw new BuildException('AddressDifferentFromAccount be a string and 1 characters');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(4, 4))
                    ->validate($saleRequestBuilder->getidNumber()):
                    $validated = false;
                    throw new BuildException('idNumber be a string and 4 characters');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType()->length(1, 6))
                    ->validate($saleRequestBuilder->getOTP()):
                    $validated = false;
                    throw new BuildException('OTP be a string and 6 characters');
                    break;
                default:
                    $validated = true;
                    break;
            }
            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
