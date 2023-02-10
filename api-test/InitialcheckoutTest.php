<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\InitiateCheckoutRequest;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\RedirectUrlsBuilder;
use App\Response\InitiateCheckoutResponse;

//Preparing support builder objects
$shippingAddress = new AddressBuilder();
$billingAddress = new AddressBuilder();
$merchantData = new MerchantDataBuilder();
$customerData = new CustomerDataBuilder();
$redirectUrls = new RedirectUrlsBuilder();
//Preparing request
$initiateCheckout = InitiateCheckoutRequest::newBuilder()
    ->withIntent('initiate')
    ->withMerchantData(
        $merchantData->withPaymentGatewayId('824B9F3B-D3CC-4A4D-A0C7-9E7B9562D147')
            ->withMerchantNumber('950000000')
            ->withStoreNumber('950000035')
            ->withSource('ECOM')
    )
    ->withLastFourDigits('1221')
    ->withCustomerData(
        $customerData->withCustomerFirstName('JEFFREY')
            ->withCustomerEmail('STO-SUPPORT@FAIRSTONE.CA')
            ->withCustomerLastName('YO')
    )
    ->withCreationTimeStamp(time())
    ->withBillingAddress(
        $billingAddress->withPersonName('JEFFREY YO')
            ->withFirstName('JEFFREY')
            ->withLastName('YO')
            ->withLine1("1722 RUE D'\''OXFORD")
            ->withCity('SAINT-LAURENT')
            ->withStateProvinceCode('SK')
            ->withPostalCode('S0G4V0')
            ->withCountryCode('CA')
    )
    ->withShippingAddress(
        $shippingAddress->withPersonName('JEFFREY YO')
            ->withFirstName('JEFFREY')
            ->withLastName('YO')
            ->withLine1("1722 RUE D'\''OXFORD")
            ->withCity('SAINT-LAURENT')
            ->withStateProvinceCode('QC')
            ->withPostalCode('G9T5X9')
            ->withCountryCode('CA')
    )
    ->withTotalAmount(10.00)
    ->withCurrency('CAD')
    ->withRedirectUrls(
        $redirectUrls->withFailureUrl("https://merchantsite.com/cancel")
            ->withCancelUrl("https://merchantsite.com/failure")
            ->withSuccessUrl("https://merchantsite.com/return")
    )
    ->withCallbackUrl("")
    ->withCallbackKey("")
    ->build();
//Making HTTP Request and Initializing Response.
if ($initiateCheckout instanceof InitiateCheckoutRequest) {
    $api_response = $initiateCheckout->initiateRequest();
    if ($api_response != '') {
        $response = new InitiateCheckoutResponse($api_response);
        $response->getRAWResponse();
    }
}
