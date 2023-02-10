<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\CreateOtpRequest;
use App\Builder\Support\CreateOtpMerchantDataBuilder;
use App\Response\CreateOtpResponse;

//Preparing support builder objects
$merchantData = new CreateOtpMerchantDataBuilder();
//Preparing request

$CustomerAccountUpdate = CreateOtpRequest::newBuilder()
    ->withaccountNumber('0006030491300001551')
    ->withphoneNumber('7567464654')
    ->withsalePerson('sale 1')
    ->withmerchantData(
        $merchantData->withPaymentGatewayId('0686FFEC-F517-4C13-8989-9B118C54F9F9') //
        ->withMerchantNumber('950000053') //
        ->withStoreNumber('950002062') //
    )
    ->build();
//Making HTTP Request and Initializing Response.
if ($CustomerAccountUpdate instanceof CreateOtpRequest) {
    $api_response = $CustomerAccountUpdate->initiateRequest();
    if ($api_response != '') {
        $response = new CreateOtpResponse($api_response);
        $response->getRAWResponse();
    }
}
