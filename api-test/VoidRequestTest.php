<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\VoidRequest;
use App\Configuration\Configuration;
use App\Response\VoidResponse;

//Calling the request object with parameters
$voidRequest = VoidRequest::newBuilder()
    ->withTransactionId('001910019119001313038202002050033')
    ->withAccountNumber('0006030491300001551')
    ->withMerchantNumber('950000053')
    ->withStoreNumber('950002062')
    ->withCreditPlan('12035')
    ->withTransactionType('VOID')
    ->withAuthorizationCode('000009')
    ->withTransactionAmount(10.00)
    ->withInvoiceNumber('123')
    ->withSalePerson('user123')
    ->withcancelType('RETURN')
    ->withTransactionDate(Configuration::getDate())
    ->build();
//Making HTTP Request and Initializing Response.
if ($voidRequest instanceof VoidRequest) {
    $api_response = $voidRequest->initiateRequest();
    if ($api_response != '') {
        $response = new VoidResponse($api_response);
        $response->getRAWResponse();
    }
}
