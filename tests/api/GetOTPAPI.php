<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\GetOtpRequest;
use App\Response\GetOtpResponse;

class GetOTPAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $createOtpRequest = GetOtpRequest::newBuilder()
                ->withAccountNumber($testData["AccountNumber"])
                ->withPhoneNumber($testData["HomePhone"])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Get OTP", $testData);

            $apiResponse = $createOtpRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Get OTP",
                json_decode($apiResponse, true));

            $getOtpResponse = new GetOtpResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [GetOTPAPI]",
                $getOtpResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [GetOTPAPI]",
                $getOtpResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for Pin [GetOTPAPI]",
                $getOtpResponse->getPin());
            $testCaseHandler->assertNotNull("Verification for PinExpirationTime [GetOTPAPI]",
                $getOtpResponse->getPinExpirationTime());

            return $getOtpResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in GetOTPAPI",
                $exception->getMessage());
        }
    }
}
