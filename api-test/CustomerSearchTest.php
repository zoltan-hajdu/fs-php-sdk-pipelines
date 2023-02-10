<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\CustomerSearchRequest;

use App\Response\CustomerSearchResponse;

//Preparing request
$customerSearchRequest = CustomerSearchRequest::newBuilder()
    //->withCustomerId('0006030491260000205')
    ->withMerchantNumber('950000000')
    ->withStoreNumber('950000000')
    ->withphoneNo('5816681405')
    ->withfirstName('BËLL')
    ->withlastName('TËSTFILLER')
    ->withpostalCode('J7G3J6')
    ->build();

//Making HTTP Request and Initializing Response.
if ($customerSearchRequest instanceof CustomerSearchRequest) {
    $api_response = $customerSearchRequest->initiateRequest();
    if ($api_response != '') {
        $response = new CustomerSearchResponse($api_response);
        $response->getRAWResponse();
    }
}
