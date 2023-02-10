<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\InitiateCheckoutBuilder;

class InitiateCheckoutValidator
{
    public static function validate(InitiateCheckoutBuilder $initiateCheckoutBuilder): bool
    {
        try {
            $validated = true;
            $initialcheckout = RespectValidator::stringType();

            $BillingAddress = $initiateCheckoutBuilder->getBillingAddress();
            $ShippingAddress = $initiateCheckoutBuilder->getShippingAddress();

            switch (!$initialcheckout) {
                case RespectValidator::floatVal()->positive()->validate($initiateCheckoutBuilder->getTotalAmount()):
                    $validated = false;
                    throw new BuildException('totalAmount must be a float.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getRedirectUrls()
                    ->getCancelUrl()):
                    $validated = false;
                    throw new BuildException('redirect_urls / cancel_url must be a string.');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType()->length(4, 4))
                    ->validate($initiateCheckoutBuilder->getLastFourDigits()):
                    $validated = false;
                    throw new BuildException('lastFourDigits must be a string of 4 characters.');
                    break;
                case  RespectValidator::nullable(RespectValidator::stringType())
                    ->validate($initiateCheckoutBuilder->getRedirectUrls()->getFailureUrl()):
                    $validated = false;
                    throw new BuildException('redirect_urls / failure_url must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getRedirectUrls()
                    ->getSuccessUrl()):
                    $validated = false;
                    throw new BuildException('redirect_urls / success_url must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getMerchantData()
                    ->getPaymentGatewayId()):
                    $validated = false;
                    throw new BuildException('merchantData / paymentGatewayId must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getMerchantData()
                    ->getMerchantNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / merchantNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getMerchantData()
                    ->getStoreNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / storeNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getMerchantData()->getSource()):
                    $validated = false;
                    throw new BuildException('merchantData / source must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getCustomerData()
                    ->getCustomerFirstName()):
                    $validated = false;
                    throw new BuildException('customerData / customerFirstName must be a string.');
                    break;
                case RespectValidator::nullable(RespectValidator::stringType())
                    ->validate($initiateCheckoutBuilder->getCustomerData()->getCustomerEmail()):
                    $validated = false;
                    throw new BuildException('customerData / customerEmail must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getCustomerData()
                    ->getCustomerLastName()):
                    $validated = false;
                    throw new BuildException('customerData / customerLastName must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getPersonName()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getPersonName()):
                    $validated = false;
                    throw new BuildException('personName must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getFirstName()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getFirstName()):
                    $validated = false;
                    throw new BuildException(' firstName must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getLastName()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getLastName()):
                    $validated = false;
                    throw new BuildException('LastName must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getCity()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getCity()):
                    $validated = false;
                    throw new BuildException(' City must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->length(2, 2)
                        ->validate($BillingAddress->getCountryCode()) && RespectValidator::stringType()
                        ->length(2, 2)
                        ->validate($ShippingAddress->getCountryCode()):
                    $validated = false;
                    if (!RespectValidator::stringType()->validate($BillingAddress->getPostalCode())) {
                        throw new BuildException('BillingAddress / CountryCode must be a string of 2 characters.');
                    } else {
                        throw new BuildException('ShippingAddress / CountryCode must be a string of 2 characters.');
                    }
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getPostalCode()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getPostalCode()):
                    $validated = false;
                    throw new BuildException(' PostalCode must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getLine1()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getLine1()):
                    $validated = false;
                    throw new BuildException('Line1 must be a string.');
                    break;
                case RespectValidator::stringType()
                        ->validate($BillingAddress->getStateProvinceCode()) && RespectValidator::stringType()
                        ->validate($ShippingAddress->getStateProvinceCode()):
                    $validated = false;
                    throw new BuildException('StateProvinceCode must be a string.');
                    break;
                case RespectValidator::intVal()->positive()->validate($initiateCheckoutBuilder->getCreationTimeStamp()):
                    $validated = false;
                    throw new BuildException('creationTimeStamp must be an integer.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getIntent()):
                    $validated = false;
                    throw new BuildException('intent must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getCurrency()):
                    $validated = false;
                    throw new BuildException('currency must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getCallbackUrl()):
                    $validated = false;
                    throw new BuildException('callbackUrl must be a string.');
                    break;
                case RespectValidator::stringType()->validate($initiateCheckoutBuilder->getCallbackKey()):
                    $validated = false;
                    throw new BuildException('callbackKey must be a string.');
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
