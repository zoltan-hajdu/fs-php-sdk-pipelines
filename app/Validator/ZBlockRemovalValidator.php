<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\ZBlockRemovalBuilder;

class ZBlockRemovalValidator
{
    public static function validate(ZBlockRemovalBuilder $ZBlockRemovalBuilder): bool
    {
        try {

            if (!RespectValidator::stringType()
                ->length(1, 25)
                ->validate($ZBlockRemovalBuilder->getcustomerId())) {

                throw new BuildException('Customer Id must be a string of 25 characters');
            }

            if (!RespectValidator::stringType()
                ->length(9, 9)
                ->validate($ZBlockRemovalBuilder->getmerchantNumber())) {

                throw new BuildException('MerchantNumber must be a string of 9 characters');
            }

            if (!RespectValidator::intVal()
                ->positive()
                ->length(9, 9)
                ->validate($ZBlockRemovalBuilder->getstoreNumber())) {

                throw new BuildException('storeNumber must be a Integer of 9 characters');
            }

            $id1IssuerType = $ZBlockRemovalBuilder->getId1()->getissuerType();
            if ($id1IssuerType && (!RespectValidator::stringType()->validate($id1IssuerType))) {

                throw new BuildException('Issurtype must be a string.');
            }

            $id1IdType = $ZBlockRemovalBuilder->getId1()->getidType();
            if ($id1IdType && (!RespectValidator::stringType()->validate($id1IdType))) {

                throw new BuildException('IdType must be a string.');
            }

            $id1ProvinceIssued = $ZBlockRemovalBuilder->getId1()->getprovinceIssued();
            if ($id1ProvinceIssued &&
                (!RespectValidator::stringType()->length(2, 2)->validate($id1ProvinceIssued))) {

                throw new BuildException('provinceIssued must be a string of 2 characters.');
            }

            $id1AddressVerificationNeeded = $ZBlockRemovalBuilder->getId1()->getaddressVerificationNeeded();
            if ($id1AddressVerificationNeeded && (!RespectValidator::stringType()->validate
            ($id1AddressVerificationNeeded))) {

                throw new BuildException('addressVerificationNeeded must be a string.');
            }

            $id2IssuerType = $ZBlockRemovalBuilder->getId2()->getissuerType();
            if ($id2IssuerType && (!RespectValidator::stringType()->validate($id2IssuerType))) {

                throw new BuildException('Issurtype must be a string.');
            }

            $id2IdType = $ZBlockRemovalBuilder->getId2()->getidType();
            if ($id2IdType && (!RespectValidator::stringType()->validate($id2IdType))) {

                throw new BuildException('IdType must be a string.');
            }

            $id2ProvinceIssued = $ZBlockRemovalBuilder->getId2()->getprovinceIssued();
            if ($id2ProvinceIssued && (!RespectValidator::stringType()->length(2, 2)->validate($id2ProvinceIssued))) {

                throw new BuildException('provinceIssued must be a string of 2 characters.');
            }

            $id2AddressVerificationNeeded = $ZBlockRemovalBuilder->getId2()->getaddressVerificationNeeded();
            if ($id2AddressVerificationNeeded && (!RespectValidator::stringType()->validate
            ($id2AddressVerificationNeeded))) {

                throw new BuildException('addressVerificationNeeded must be a string.');
            }

            return true;
        } catch (BuildException $e) {
            echo $e->errorMessage();
            throw new \Exception($e->errorMessage());
        }
    }
}
