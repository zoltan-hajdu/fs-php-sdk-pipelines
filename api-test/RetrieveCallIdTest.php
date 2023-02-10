<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\RetrieveCallIdRequest;
use App\Response\RetrieveCallIdResponse;

//Preparing request
$retrieveCallIdRequest = RetrieveCallIdRequest::newBuilder()
    ->withCallId('a9ef6dd7dec08f29e8f32d24764f422d47459f96')
    ->build();

//Making HTTP Request and Initializing Response.
if ($retrieveCallIdRequest instanceof RetrieveCallIdRequest) {
    $api_response = $retrieveCallIdRequest->initiateRequest();
    if ($api_response != '') {
        $response = new RetrieveCallIdResponse($api_response);
        $response->getRAWResponse();
    }
}
