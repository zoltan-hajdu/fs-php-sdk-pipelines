<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\VoidAuthorizationBuilder;

class VoidAuthorizationValidator
{
    public static function validate(VoidAuthorizationBuilder $voidAuthorizationBuilder): bool
    {
        try {
            $validated = true;
            $voidauthrizationvalidate = RespectValidator::stringType();
            switch (!$voidauthrizationvalidate) {
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getIntent()):
                    $validated = false;
                    throw new BuildException('intent must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getTransactionId()):
                    $validated = false;
                    throw new BuildException('transactionId must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getMerchantData()
                    ->getPaymentGatewayId()):
                    $validated = false;
                    throw new BuildException('merchantData / paymentGatewayId must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getMerchantData()
                    ->getMerchantNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / merchantNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getMerchantData()
                    ->getStoreNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / storeNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getMerchantData()
                    ->getSource()):
                    $validated = false;
                    throw new BuildException('merchantData / source must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getDetails()
                    ->getMerchantNumber()):
                    $validated = false;
                    throw new BuildException('details / merchantNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($voidAuthorizationBuilder->getDetails()
                    ->getAccountNumber()):
                    $validated = false;
                    throw new BuildException('details / AccountNumber must be a string.');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType()->length(4, 4))
                    ->validate($voidAuthorizationBuilder->getDetails()->getLastFourDigits()):
                    $validated = false;
                    throw new BuildException('details / lastFourDigits must be a string and 4 characters.');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType())
                    ->validate($voidAuthorizationBuilder->getDetails()->getOvv()):
                    $validated = false;
                    throw new BuildException('details / ovv must be a string.');
                    break;
                case RespectValidator::stringType()->length(6, 6)->validate($voidAuthorizationBuilder->getDetails()
                    ->getAuthorizationCode()):
                    $validated = false;
                    throw new BuildException('details / authorizationCode must be a string of 6 characters.');
                    break;
                case RespectValidator::stringType()->length(4, 6)->validate($voidAuthorizationBuilder->getDetails()
                    ->getCreditPlan()):
                    $validated = false;
                    throw new BuildException('details / creditPlan must be a string of 4 to 6 characters.');
                    break;
                case RespectValidator::floatVal()->positive()->validate($voidAuthorizationBuilder->getDetails()
                    ->getAmount()):
                    $validated = false;
                    throw new BuildException('details / amount must be a string of 4 to 6 characters.');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType())
                    ->validate($voidAuthorizationBuilder->getDetails()->getDescription()):
                    $validated = false;
                    throw new BuildException('details / description must be a string.');
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
