<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Builder\Support\CreateOtpMerchantDataBuilder;
use App\Request\CreateOtpRequest;
use App\Response\CreateOtpResponse;

class CreateOTPAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        $merchantData = new CreateOtpMerchantDataBuilder();

        try {
            $createOtpRequest = CreateOtpRequest::newBuilder()
                ->withaccountNumber($testData["AccountNumber"])
                ->withphoneNumber($testData["HomePhone"])
                ->withsalePerson($testData["SalePerson"])
                ->withmerchantData(
                    $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                        ->withMerchantNumber($testData["MerchantNumber"])
                        ->withStoreNumber($testData["StoreNumber"])
                )
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Create OTP", $testData);

            $apiResponse = $createOtpRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Create OTP",
                json_decode($apiResponse, true));

            $customerSearchRespose = new CreateOtpResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [CreateOTPAPI]",
                $customerSearchRespose->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [CreateOTPAPI]",
                $customerSearchRespose->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [CreateOTPAPI]",
                $customerSearchRespose->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [CreateOTPAPI]",
                $customerSearchRespose->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [CreateOTPAPI]",
                $customerSearchRespose->getAccountNumber(),
                $testData["AccountNumber"]);

            return $customerSearchRespose;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in CreateOTPAPI",
                $exception->getMessage());
        }
    }
}
