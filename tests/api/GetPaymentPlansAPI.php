<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\GetPaymentPlanRequest;
use App\Response\GetPaymentPlanResponse;

class GetPaymentPlansAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $getPaymentPlanRequest = GetPaymentPlanRequest::newBuilder()
                ->withAmount($testData["Amount"])
                ->withMerchant($testData["MerchantNumber"])
                ->withLang($testData["Language"])
                ->withProv($testData["Province"])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("PaymentPlans", $testData);

            $apiResponse = $getPaymentPlanRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Get Payment Plans API",
                json_decode($apiResponse, true));

            $paymentPlansResponse = new GetPaymentPlanResponse($apiResponse);
            $paymentPlans = $paymentPlansResponse->getpaymentPlans();

            $testCaseHandler->assertEquals("Verification for Status code [GetPaymentPlansAPI]",
                $paymentPlansResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [GetPaymentPlansAPI]",
                $paymentPlansResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertTrue("Verification for paymentPlans " . count($paymentPlans),
                count($paymentPlans) > 0);

            return $paymentPlansResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in GetPaymentPlansAPI",
                $exception->getMessage());
        }
    }
}
