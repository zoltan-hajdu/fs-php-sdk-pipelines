<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\RetrieveCallIdBuilder;

class RetrieveCallIdValidator
{
    public static function validate(RetrieveCallIdBuilder $retrieveCallIdBuilder): bool
    {
        try {
            $validated = true;
            if (!RespectValidator::stringType()->validate($retrieveCallIdBuilder->getCallId())) {
                $validated = false;
                throw new BuildException('callId must be a string');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
