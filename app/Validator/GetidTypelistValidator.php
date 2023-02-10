<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\GetidTypelistBuilder;

class GetidTypelistValidator
{
    public static function validate(GetidTypelistBuilder $getPaymentPlanBuilder): bool
    {
        try {
            $validated = true;

            if (!RespectValidator::stringType()
                ->length(2, 2)
                ->validate($getPaymentPlanBuilder->getcustomerProvince())) {
                $validated = false;
                throw new BuildException('customer Province must be a string of 2 characters');
            }

            return $validated;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
