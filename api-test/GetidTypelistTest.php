<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\GetidTypelistRequest;
use App\Response\GetidTypelistResponse;

//Preparing request
$getidTypelistRequest = GetidTypelistRequest::newBuilder()
    ->withissuerType('Primary')
    ->withcustomerProvince('QC')
    ->build();

//Making HTTP Request and Initializing Response.
if ($getidTypelistRequest instanceof GetidTypelistRequest) {
    $api_response = $getidTypelistRequest->initiateRequest();
    if ($api_response != '') {
        $response = new GetidTypelistResponse($api_response);
        $response->getRAWResponse();
    }
}
