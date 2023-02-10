<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Configuration\Configuration;
use App\Request\VoidRequest;
use App\Response\CustomerSearchResponse;
use App\Response\ReturnResponse;
use App\Response\VoidResponse;
use App\Response\SaleResponse;
use PHPUnit\Framework\TestCase;

class VoidAPI
{
    public static function build(SaleResponse $saleResponse, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $voidRequest = VoidRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $saleResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = empty($testData["AuthorizationCode"]) ?
                    $saleResponse->getAuthorizationCode() : $testData["AuthorizationCode"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Void", $testData);

            $apiResponse = $voidRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Void Build", json_decode($apiResponse, true));

            $voidResponse = new VoidResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [VoidAPIBuild]",
                $voidResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [VoidAPIBuild]",
                $voidResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [VoidAPIBuild]",
                $voidResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [VoidAPIBuild]",
                $voidResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [VoidAPIBuild]",
                $voidResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [VoidAPIBuild]",
                $voidResponse->getAccountNumber(),
                $testData["RAccountNumber"]);
            $testCaseHandler->assertEquals("Verification for Description [VoidAPIBuild]",
                $voidResponse->getDescription(),
                $testData["RDescription"]);

            return $voidResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in VoidAPIBuild",
                $exception->getMessage());
        }
    }

    public static function return(ReturnResponse $returnResponse, $authorizationCode, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $voidRequest = VoidRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $returnResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $returnResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withAuthorizationCode($authorizationCode)
                //->withAuthorizationCode('')
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Void", $testData);

            $apiResponse = $voidRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Void Return", json_decode($apiResponse, true));

            $voidResponse = new VoidResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status code [VoidAPIReturn]",
                $voidResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [VoidAPIReturn]",
                $voidResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [VoidAPIReturn]",
                $voidResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [VoidAPIReturn]",
                $voidResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [VoidAPIReturn]",
                $voidResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [VoidAPIReturn]",
                $voidResponse->getAccountNumber(),
                $testData["RAccountNumber"]);
            $testCaseHandler->assertEquals("Verification for Description [VoidAPIReturn]",
                $voidResponse->getDescription(),
                $testData["RDescription"]);

            return $voidResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in VoidAPIReturn",
                $exception->getMessage());
        }
    }


    public static function perform(SaleResponse $saleResponse, $authorizationResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $voidRequest = VoidRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $saleResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = $authorizationResponse->getAuthorizationCode())
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Void", $testData);

            $apiResponse = $voidRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Void Perform", json_decode($apiResponse, true));

            $voidResponse = new VoidResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [VoidAPIPerform]",
                $voidResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [VoidAPIPerform]",
                $voidResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [VoidAPIPerform]",
                $voidResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [VoidAPIPerform]",
                $voidResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [VoidAPIPerform]",
                $voidResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [VoidAPIPerform]",
                $voidResponse->getAccountNumber(),
                $testData["RAccountNumber"]);
            $testCaseHandler->assertEquals("Verification for Description [VoidAPIPerform]",
                $voidResponse->getDescription(),
                $testData["RDescription"]);

            return $voidResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in VoidAPIPerform",
                $exception->getMessage());
        }
    }
}
