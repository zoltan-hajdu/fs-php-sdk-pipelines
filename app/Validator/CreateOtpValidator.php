<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\CreateOtpBuilder;

class CreateOtpValidator
{
    public static function validate(CreateOtpBuilder $CreateOtpBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->validate($CreateOtpBuilder->getmerchantData()
                ->getPaymentGatewayId())) {
                $validated = false;
                throw new BuildException('PaymentGatewayId must be a string.');
            }
            if (!RespectValidator::stringType()->length(9, 9)->validate($CreateOtpBuilder->getmerchantData()
                ->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('MerchantNumber must be a string of 9 characters.');
            }
            if (!RespectValidator::intVal()->positive()->length(9, 9)->validate($CreateOtpBuilder->getmerchantData()
                ->getStoreNumber())) {
                $validated = false;
                throw new BuildException('StoreNumber must be a Integer of 9 characters.');
            }

            if (!RespectValidator::stringType()->length(19, 19)->validate($CreateOtpBuilder->getaccountNumber())) {
                $validated = false;
                throw new BuildException('AccountNumber must be a string of 19 characters');
            }
            if (!RespectValidator::intVal()
                ->positive()
                ->length(10, 10)
                ->validate($CreateOtpBuilder->getphoneNumber())) {
                $validated = false;
                throw new BuildException('phoneNumber must be a Integer of 10 characters');
            }

            if (!RespectValidator::stringType()->length(1, 12)->validate($CreateOtpBuilder->getsalePerson())) {
                $validated = false;
                throw new BuildException('SalePerson must be a string of 1 to 12 characters');
            }
            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
