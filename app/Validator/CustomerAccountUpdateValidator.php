<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\CustomerAccountUpdateBuilder;

class CustomerAccountUpdateValidator
{
    public static function validate(CustomerAccountUpdateBuilder $CustomerAccountUpdateBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()
                ->length(1, 25)
                ->validate($CustomerAccountUpdateBuilder->getcustomerId())) {
                $validated = false;
                throw new BuildException('Customer Id must be a string of 25 characters');
            }
            if (!RespectValidator::stringType()
                ->length(9, 9)
                ->validate($CustomerAccountUpdateBuilder->getmerchantNumber())) {
                $validated = false;
                throw new BuildException('MerchantNumber must be a string of 9 characters');
            }

            if (!RespectValidator::intVal()
                ->positive()
                ->length(9, 9)
                ->validate($CustomerAccountUpdateBuilder->getstoreNumber())) {
                $validated = false;
                throw new BuildException('storeNumber must be a Integer of 9 characters');
            }

            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId1()->getissuerType())) {
                $validated = false;
                throw new BuildException('Issurtype must be a string.');
            }
            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId1()->getidType())) {
                $validated = false;
                throw new BuildException('IdType must be a string.');
            }
            if (!RespectValidator::stringType()->length(2, 2)->validate($CustomerAccountUpdateBuilder->getId1()
                ->getprovinceIssued())) {
                $validated = false;
                throw new BuildException('provinceIssued must be a string of 2 characters.');
            }

            if (!RespectValidator::stringType()->length(4, 4)->validate($CustomerAccountUpdateBuilder->getId1()
                ->getidNumber())) {
                $validated = false;
                throw new BuildException('idNumber must be a string of 4 characters.');
            }

            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId1()
                ->getaddressVerificationNeeded())) {
                $validated = false;
                throw new BuildException('addressVerificationNeeded must be a string.');
            }

            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId2()->getissuerType())) {
                $validated = false;
                throw new BuildException('Issurtype must be a string.');
            }
            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId2()->getidType())) {
                $validated = false;
                throw new BuildException('IdType must be a string.');
            }
            if (!RespectValidator::stringType()->length(2, 2)->validate($CustomerAccountUpdateBuilder->getId2()
                ->getprovinceIssued())) {
                $validated = false;
                throw new BuildException('provinceIssued must be a string of 2 characters.');
            }

            if (!RespectValidator::stringType()->length(4, 4)->validate($CustomerAccountUpdateBuilder->getId2()
                ->getidNumber())) {
                $validated = false;
                throw new BuildException('idNumber must be a string of 4 characters.');
            }

            if (!RespectValidator::stringType()->validate($CustomerAccountUpdateBuilder->getId2()
                ->getaddressVerificationNeeded())) {
                $validated = false;
                throw new BuildException('addressVerificationNeeded must be a string.');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
