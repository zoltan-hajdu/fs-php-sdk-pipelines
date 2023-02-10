<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\GetidTypelistRequest;
use App\Response\GetidTypelistResponse;

class GetIDTypeListAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $getidTypelistRequest = GetidTypelistRequest::newBuilder()
                ->withissuerType($testData['IssuerType'])
                ->withcustomerProvince($testData['Province'])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("GetIDTypeList", $testData);

            $apiResponse = $getidTypelistRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Get ID Type List API",
                json_decode($apiResponse, true));

            $idTypeListResponse = new GetidTypelistResponse($apiResponse);
            $idTypeList = $idTypeListResponse->getidTypeList();

            $testCaseHandler->assertEquals("Verification for Status code [GetIDTypeListAPI]",
                $idTypeListResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [GetIDTypeListAPI]",
                $idTypeListResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertTrue("Verification for idTypeList " . count($idTypeList), count($idTypeList) > 0);

            return $idTypeListResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in GetIDTypeListAPI",
                $exception->getMessage());
        }
    }
}
