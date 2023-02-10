<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\ReversalRequest;
use App\Configuration\Configuration;
use App\Response\ReversalResponse;

//Preparing request
$reversalRequest = ReversalRequest::newBuilder()
    ->withTransactionId('001910019119001313038202002050034')
    ->withAccountNumber('0006030491300001551')
    ->withMerchantNumber('950000053')
    ->withStoreNumber('950002062')
    ->withCreditPlan('12035')
    ->withTransactionType('REVERSAL')
    ->withTransactionAmount(10.00)
    ->withSalePerson('user123')
    ->withcancelType('SALE')
    //->withAuthorizationCode('000009')
    ->withTransactionDate(Configuration::getDate())
    ->build();

//Making HTTP Request and Initializing Response.
if ($reversalRequest instanceof ReversalRequest) {
    $api_response = $reversalRequest->initiateRequest();
    if ($api_response != '') {
        $response = new ReversalResponse($api_response);
        $response->getRAWResponse();
    }
}
