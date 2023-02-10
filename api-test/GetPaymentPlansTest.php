<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\GetPaymentPlanRequest;
use App\Response\GetPaymentPlanResponse;

//Preparing request
$getPaymentPlanRequest = GetPaymentPlanRequest::newBuilder()
    ->withAmount(501.00)
    ->withMerchant('64A73847-699F-4027-862C-46119FD202C7')
    ->withLang('EN')
    ->withProv('QC')
    ->build();

//Making HTTP Request and Initializing Response.
if ($getPaymentPlanRequest instanceof GetPaymentPlanRequest) {
    $api_response = $getPaymentPlanRequest->initiateRequest();
    if ($api_response != '') {
        $response = new GetPaymentPlanResponse($api_response);
        $response->getRAWResponse();
    }
}
