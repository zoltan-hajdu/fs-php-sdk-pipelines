<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\VoidAuthorizationRequest;
use App\Response\VoidAuthorizationResponse;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\MerchantDetailsBuilder;

$merchantData = new MerchantDataBuilder();
$detail = new MerchantDetailsBuilder();

//Preparing request

$voidAuthorizationRequest = VoidAuthorizationRequest::newBuilder()
    ->withtransactionId('29102021091060')
    ->withIntent('void')
    ->withMerchantData(
        $merchantData->withPaymentGatewayId('824B9F3B-D3CC-4A4D-A0C7-9E7B9562D147')
            ->withMerchantNumber('950000000')
            ->withStoreNumber('950000035')
            ->withSource('ECOM')
    )
    ->withDetails(
        $detail->withmerchantNumber('950000000')
            ->withaccountNumber('0006030491300001569')
            ->withlastFourDigits('1221')
            ->withovv('3c9f86b1650f2f6384192af85bd9f0727b8d2a92')
            ->withauthorizationCode('030227')
            ->withcreditPlan('13125')
            ->withamount(5.00)
            ->withdescription('order item cancelled')
    )
    ->build();
//Making HTTP Request and Initializing Response.
if ($voidAuthorizationRequest instanceof VoidAuthorizationRequest) {
    $api_response = $voidAuthorizationRequest->initiateRequest();
    if ($api_response != '') {
        $response = new VoidAuthorizationResponse($api_response);
        $response->getRAWResponse();
    }
}
