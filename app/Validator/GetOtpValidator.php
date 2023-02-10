<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\GetOtpBuilder;

class GetOtpValidator
{
    public static function validate(GetOtpBuilder $getOtpBuilder): bool
    {
        try {
            if (!RespectValidator::stringType()->length(19, 19)->validate($getOtpBuilder->getaccountNumber())) {
                throw new BuildException('AccountNumber must be a string of 19 characters');
            }
            if (!RespectValidator::intVal()
                ->positive()
                ->length(10, 10)
                ->validate($getOtpBuilder->getphoneNumber())) {
                throw new BuildException('phoneNumber must be a Integer of 10 characters');
            }
            return true;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
