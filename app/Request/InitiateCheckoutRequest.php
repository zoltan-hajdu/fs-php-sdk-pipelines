<?php
//define Return Request class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\InitiateCheckoutBuilder;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\RedirectUrlsBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;

class InitiateCheckoutRequest extends BaseRequest
{
    private float $totalAmount;
    private string $lastFourDigits;
    private RedirectUrlsBuilder $redirectUrls;
    private AddressBuilder $shippingAddress;
    private MerchantDataBuilder $merchantData;
    private CustomerDataBuilder $customerData;
    private string $currency;
    private int $creationTimeStamp;
    private AddressBuilder $billingAddress;
    private string $intent;
    private string $callbackUrl;
    private string $callbackKey;
    private $END_POINT = 'v1/checkout/initiate';

    public function __construct(InitiateCheckoutBuilder $initiateCheckoutBuilder)
    {
        $this->totalAmount = $initiateCheckoutBuilder->getTotalAmount();
        if ($initiateCheckoutBuilder->getLastFourDigits() != null) {
            $this->lastFourDigits = $initiateCheckoutBuilder->getLastFourDigits();
        }
        $this->redirectUrls = $initiateCheckoutBuilder->getRedirectUrls();
        $this->shippingAddress = $initiateCheckoutBuilder->getShippingAddress();
        $this->merchantData = $initiateCheckoutBuilder->getMerchantData();
        $this->customerData = $initiateCheckoutBuilder->getCustomerData();
        $this->currency = $initiateCheckoutBuilder->getCurrency();
        $this->creationTimeStamp = $initiateCheckoutBuilder->getCreationTimeStamp();
        $this->billingAddress = $initiateCheckoutBuilder->getBillingAddress();
        $this->intent = $initiateCheckoutBuilder->getIntent();
        $this->callbackUrl = $initiateCheckoutBuilder->getCallbackUrl();
        $this->callbackKey = $initiateCheckoutBuilder->getCallbackKey();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['intent'] = $this->intent;
        $transaction_data['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        if (isset($this->lastFourDigits)) {
            $transaction_data['lastFourDigits'] = $this->lastFourDigits;
        }
        $transaction_data['customerData'] = array();
        $transaction_data['customerData']['customerFirstName'] = $this->customerData->getCustomerFirstName();
        if ($this->customerData->getCustomerEmail() != null) {
            $transaction_data['customerData']['customerEmail'] = $this->customerData->getCustomerEmail();
        }
        $transaction_data['customerData']['customerLastName'] = $this->customerData->getCustomerLastName();

        $transaction_data['creationTimeStamp'] = $this->creationTimeStamp;
        $transaction_data['billingAddress'] = array(
            'personName' => $this->billingAddress->getPersonName(),
            'firstName' => $this->billingAddress->getFirstName(),
            'lastName' => $this->billingAddress->getLastName(),
            'city' => $this->billingAddress->getCity(),
            'countryCode' => $this->billingAddress->getCountryCode(),
            'postalCode' => $this->billingAddress->getPostalCode(),
            'line1' => $this->billingAddress->getLine1(),
            'stateProvinceCode' => $this->billingAddress->getStateProvinceCode()

        );
        $transaction_data['shippingAddress'] = array(
            'personName' => $this->shippingAddress->getPersonName(),
            'firstName' => $this->shippingAddress->getFirstName(),
            'lastName' => $this->shippingAddress->getLastName(),
            'city' => $this->shippingAddress->getCity(),
            'countryCode' => $this->shippingAddress->getCountryCode(),
            'postalCode' => $this->shippingAddress->getPostalCode(),
            'line1' => $this->shippingAddress->getLine1(),
            'stateProvinceCode' => $this->shippingAddress->getStateProvinceCode()

        );

        $transaction_data['totalAmount'] = number_format((float)$this->totalAmount, 2, '.', '');
        $transaction_data['currency'] = $this->currency;
        $transaction_data['redirect_urls'] = array();
        if ($this->redirectUrls->getFailureUrl() != null) {
            $transaction_data['redirect_urls']['failure_url'] = $this->redirectUrls->getFailureUrl();
        }
        $transaction_data['redirect_urls']['cancel_url'] = $this->redirectUrls->getCancelUrl();
        $transaction_data['redirect_urls']['success_url'] = $this->redirectUrls->getSuccessUrl();
        $transaction_data['callback_url'] = $this->callbackUrl;
        $transaction_data['callback_key'] = $this->callbackKey;

//Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['intent'] = $this->intent;
        $transaction_data_logger['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        if (isset($this->lastFourDigits)) {
            $transaction_data_logger['lastFourDigits'] = $this->lastFourDigits;
        }
        $transaction_data_logger['creationTimeStamp'] = $this->creationTimeStamp;
        $transaction_data_logger['billingAddress'] = array(
            'personName' => $this->billingAddress->getPersonName(),
            'firstName' => $this->billingAddress->getFirstName(),
            'lastName' => $this->billingAddress->getLastName(),
            'city' => $this->billingAddress->getCity(),
            'countryCode' => $this->billingAddress->getCountryCode(),
            'postalCode' => $this->billingAddress->getPostalCode(),
            'line1' => $this->billingAddress->getLine1(),
            'stateProvinceCode' => $this->billingAddress->getStateProvinceCode()

        );
        $transaction_data_logger['shippingAddress'] = array(
            'personName' => $this->shippingAddress->getPersonName(),
            'firstName' => $this->shippingAddress->getFirstName(),
            'lastName' => $this->shippingAddress->getLastName(),
            'city' => $this->shippingAddress->getCity(),
            'countryCode' => $this->shippingAddress->getCountryCode(),
            'postalCode' => $this->shippingAddress->getPostalCode(),
            'line1' => $this->shippingAddress->getLine1(),
            'stateProvinceCode' => $this->shippingAddress->getStateProvinceCode()

        );
        $transaction_data_logger['totalAmount'] = number_format((float)$this->totalAmount, 2, '.', '');
        $transaction_data_logger['currency'] = $this->currency;
        $transaction_data_logger['redirect_urls'] = array(
            'failure_url' => $this->redirectUrls->getFailureUrl(),
            'cancel_url' => $this->redirectUrls->getCancelUrl(),
            'success_url' => $this->redirectUrls->getSuccessUrl()
        );
        if (isset($this->callbackUrl)) {
            $transaction_data_logger['callback_url'] = $this->callbackUrl;
        }
        $transaction_data_logger['callback_key'] = $this->callbackKey;

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Initiate Checkout Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data, 'ECOM');
        return ($response) ? $response : '';
    }

    public static function newBuilder(): InitiateCheckoutBuilder
    {
        return new InitiateCheckoutBuilder();
    }
}
