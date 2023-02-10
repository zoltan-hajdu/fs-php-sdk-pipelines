<?php

namespace App\Validator;

use Respect\Validation\Validator as RespectValidator;
use App\Exception\BuildException;
use App\Builder\OrderPostingBuilder;

class OrderPostingValidator
{
    public static function validate(OrderPostingBuilder $orderPostingBuilder): bool
    {
        try {
            $validated = true;
            $Orderpostingvalidate = RespectValidator::stringType();
            switch (!$Orderpostingvalidate) {
                case RespectValidator::stringType()->validate($orderPostingBuilder->getIntent()):
                    $validated = false;
                    throw new BuildException('intent must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getCallId()):
                    $validated = false;
                    throw new BuildException('callId must be a string.');
                    break;
                case RespectValidator::stringType()->length(4, 4)->validate($orderPostingBuilder->getLastFourDigits()):
                    $validated = false;
                    throw new BuildException('lastFourDigits must be a string of 4 characters.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getMerchantData()
                    ->getPaymentGatewayId()):
                    $validated = false;
                    throw new BuildException('merchantData / paymentGatewayId must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getMerchantData()
                    ->getMerchantNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / merchantNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getMerchantData()
                    ->getStoreNumber()):
                    $validated = false;
                    throw new BuildException('merchantData / storeNumber must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getMerchantData()->getSource()):
                    $validated = false;
                    throw new BuildException('merchantData / source must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getCustomerData()
                    ->getCustomerFirstName()):
                    $validated = false;
                    throw new BuildException('customerData / CustommerFirstname must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getCustomerData()
                    ->getCustomerEmail()):
                    $validated = false;
                    throw new BuildException('customerData / customerEmail must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getCustomerData()
                    ->getCustomerLastName()):
                    $validated = false;
                    throw new BuildException('customerData / customerLastName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()
                    ->getPersonName()):
                    $validated = false;
                    throw new BuildException('billingAddress / personName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()
                    ->getFirstName()):
                    $validated = false;
                    throw new BuildException('billingAddress / firstName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()->getLastName()):
                    $validated = false;
                    throw new BuildException('billingAddress / LastName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()->getCity()):
                    $validated = false;
                    throw new BuildException('billingAddress / City must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()
                    ->getCountryCode()):
                    $validated = false;
                    throw new BuildException('billingAddress / CountryCode must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()
                    ->getPostalCode()):
                    $validated = false;
                    throw new BuildException('billingAddress / PostalCode must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()->getLine1()):
                    $validated = false;
                    throw new BuildException('billingAddress / Line1 must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getBillingAddress()
                    ->getStateProvinceCode()):
                    $validated = false;
                    throw new BuildException('billingAddress / StateProvinceCode must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getPersonName()):
                    $validated = false;
                    throw new BuildException('shippingAddress / personName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getFirstName()):
                    $validated = false;
                    throw new BuildException('shippingAddress / firstName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getLastName()):
                    $validated = false;
                    throw new BuildException('shippingAddress / LastName must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()->getCity()):
                    $validated = false;
                    throw new BuildException('shippingAddress / City must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getCountryCode()):
                    $validated = false;
                    throw new BuildException('shippingAddress / CountryCode must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getPostalCode()):
                    $validated = false;
                    throw new BuildException('shippingAddress / PostalCode must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()->getLine1()):
                    $validated = false;
                    throw new BuildException('shippingAddress / Line1 must be a string.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getShippingAddress()
                    ->getStateProvinceCode()):
                    $validated = false;
                    throw new BuildException('shippingAddress / StateProvinceCode must be a string.');
                    break;
                case RespectValidator::intVal()->positive()->validate($orderPostingBuilder->getCreationTimeStamp()):
                    $validated = false;
                    throw new BuildException('creationTimeStamp must be an integer.');
                    break;
                case RespectValidator::stringType()->validate($orderPostingBuilder->getOrderMethod()):
                    $validated = false;
                    throw new BuildException('orderMethod must be a string.');
                    break;
                case  RespectValidator::stringType()->length(1, 25)->validate($orderPostingBuilder->getAccountNumber()):
                    $validated = false;
                    throw new BuildException('accountNumber must be a string of at most 25 characters.');
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
