<?php
/* declare(strict_types = 1); */
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\VoidAuthorizationRequest;
use App\Response\VoidAuthorizationResponse;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\MerchantDetailsBuilder;
use App\Response\AuthorizationResponse;
use PHPUnit\Framework\TestCase;

class VoidAuthorizationtestAPI
{
    public static function build(AuthorizationResponse $autorizationResponse, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $detail = new MerchantDetailsBuilder();
            $voidAuthorizationRequest = VoidAuthorizationRequest::newBuilder()
                ->withTransactionId($testData["TransactionId"] = $autorizationResponse->getTransactionId())
                ->withIntent($testData["Intent"])
                ->withMerchantData(
                    $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                        ->withMerchantNumber($testData["MerchantNumber"])
                        ->withStoreNumber($testData["StoreNumber"])
                        ->withSource($testData["Source"])
                )
                ->withDetails(
                    $detail->withMerchantNumber($testData["MerchantNumber"])
                        ->withaccountNumber($testData["AccountNumber"] = $autorizationResponse->getAccountNumber())
                        ->withlastFourDigits($testData["LastFourDigits"])
                        ->withovv($testData["OVV"] = $autorizationResponse->getOvv())
                        ->withAuthorizationCode($testData["AuthorizationCode"] = empty($testData["AuthorizationCode"]) ?
                            $autorizationResponse->getAuthorizationCode() : $testData["AuthorizationCode"])
                        ->withcreditPlan($testData["CreditPlan"])
                        ->withamount($testData["Amount"])
                        ->withdescription($testData["RDescription"])

                )
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("VoidAuthorizationTestAPI", $testData);

            $apiResponse = $voidAuthorizationRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Void Authorization Test API",
                json_decode($apiResponse, true));

            $voidAuthorizationResponse = new VoidAuthorizationResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status code [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status Description [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getResponse_description(),
                $testData["StatusDescription"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getTransactionId());
            $testCaseHandler->assertNotNull("Verification for OVV [VoidAuthorizationTestAPI]",
                $autorizationResponse->getOvv());
            $testCaseHandler->assertEquals("Verification for ResponseCode [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for Status [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getStatus(),
                $testData["Status"]);
            $testCaseHandler->assertEquals("Verification for Intent [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getIntent(),
                $testData["Intent"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getAccountNumber(),
                $testData["RAccountNumber"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getdateProcessed());
            $testCaseHandler->assertNotNull("Verification for AuthorizationCode [VoidAuthorizationTestAPI]",
                $voidAuthorizationResponse->getAuthorizationCode());

            return $voidAuthorizationResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in VoidAuthorizationTestAPI",
                $exception->getMessage());
        }
    }
}
