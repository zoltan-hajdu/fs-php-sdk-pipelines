<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\CustomerSearchBuilder;

class CustomerSearchValidator
{
    public static function validate(CustomerSearchBuilder $customerSearchBuilder): bool
    {
        try {
            $validated = true;
            $getCustomerId = $customerSearchBuilder->getCustomerId();

            if ($getCustomerId &&
                (!RespectValidator::stringType()->length(0, 25)->validate($customerSearchBuilder->getCustomerId()))) {
                $validated = false;
                throw new BuildException('accountNumber must be a string of maximum 25 characters');
            }

            if (!RespectValidator::stringType()->length(9, 9)->validate($customerSearchBuilder->getMerchantNumber())) {
                $validated = false;
                throw new BuildException('merchantNumber must be a string of at most 9 characters');
            }
            if (!RespectValidator::stringType()->length(9, 9)->validate($customerSearchBuilder->getStoreNumber())) {
                $validated = false;
                throw new BuildException('StoreNumber must be a string of 9 characters');
            }
            //3,0 SDK
            $getphoneNo = $customerSearchBuilder->getphoneNo();
            if ($getphoneNo &&
                (!RespectValidator::stringType()->length(10, 10)->validate($customerSearchBuilder->getphoneNo()))) {
                $validated = false;
                throw new BuildException('PhoneNumber must be a string of 10 characters');
            }

            $getfirstName = $customerSearchBuilder->getfirstName();
            if ($getfirstName &&
                (!RespectValidator::stringType()->validate($customerSearchBuilder->getfirstName()))) {
                $validated = false;
                throw new BuildException('FirstName must be a string');
            }

            $getlastName = $customerSearchBuilder->getlastName();
            if ($getlastName &&
                (!RespectValidator::stringType()->validate($customerSearchBuilder->getlastName()))) {
                $validated = false;
                throw new BuildException('LastName must be a string');
            }

            $getpostalCode = $customerSearchBuilder->getpostalCode();
            if ($getpostalCode &&
                (!RespectValidator::stringType()->validate($customerSearchBuilder->getpostalCode()))) {
                $validated = false;
                throw new BuildException('Postalcode must be a string');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
