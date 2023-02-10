<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\ReturnRequest;
use App\Configuration\Configuration;
use App\Response\ReturnResponse;

//Preparing request
$returnRequest = ReturnRequest::newBuilder()
    ->withTransactionId('001910019119001313038202002050033')
    ->withAccountNumber('0006030491300001551')
    ->withMerchantNumber('950000053')
    ->withStoreNumber('950002062')
    ->withCreditPlan('12035')
    ->withTransactionType('RETURN')
    ->withTransactionAmount(10.00)
    ->withInvoiceNumber('123')
    ->withAuthorizationCode('000009')
    ->withSalePerson('user123')
    ->withTransactionDate(Configuration::getDate())
    ->build();

//Making HTTP Request and Initializing Response.
if ($returnRequest instanceof ReturnRequest) {
    $api_response = $returnRequest->initiateRequest();
    if ($api_response != '') {
        $response = new ReturnResponse($api_response);
        $response->getRAWResponse();
    }
}
