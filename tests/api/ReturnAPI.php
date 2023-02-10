<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Configuration\Configuration;
use App\Request\ReturnRequest;
use App\Response\ReturnResponse;
use App\Response\AuthorizationResponse;
use App\Response\ReversalResponse;
use App\Response\SaleResponse;
use PHPUnit\Framework\TestCase;

class ReturnAPI
{
    public static function withSale(SaleResponse $saleResponse, $autorizationResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $returnRequest = ReturnRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = $autorizationResponse->getAuthorizationCode())
                ->withSalePerson($testData["SalePerson"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Return", $testData);

            $apiResponse = $returnRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Return With Sale",
                json_decode($apiResponse, true));

            $returnResponse = new ReturnResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [ReturnAPIWithSale]",
                $returnResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReturnAPIWithSale]",
                $returnResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertEquals("Verification for ResponseCode [ReturnAPIWithSale]",
                $returnResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReturnAPIWithSale]",
                $returnResponse->getdateProcessed());
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReturnAPIWithSale]",
                $returnResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [ReturnAPIWithSale]",
                $returnResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReturnAPIWithSale]",
                $returnResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $returnResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ReturnAPIWithSale",
                $exception->getMessage());
        }
    }


    public static function build(SaleResponse $saleResponse, $autorizationResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $returnRequest = ReturnRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = empty($testData["AuthorizationCode"]) ?
                    $autorizationResponse->getAuthorizationCode() : $testData["AuthorizationCode"])
                ->withSalePerson($testData["SalePerson"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Return", $testData);

            $apiResponse = $returnRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Return Build", json_decode($apiResponse, true));

            $returnResponse = new ReturnResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status code [ReturnAPIBuild]",
                $returnResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for ResponseCode [ReturnAPIBuild]",
                $returnResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReturnAPIBuild]",
                $returnResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReturnAPIBuild]",
                $returnResponse->getdateProcessed());
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReturnAPIBuild]",
                $returnResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [ReturnAPIBuild]",
                $returnResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReturnAPIBuild]",
                $returnResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $returnResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ReturnAPIBuild",
                $exception->getMessage());
        }
    }


    public static function buildR(SaleResponse $saleResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $returnRequest = ReturnRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = $saleResponse->getAuthorizationCode())
                ->withSalePerson($testData["SalePerson"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Return", $testData);

            $apiResponse = $returnRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Return BuildR", json_decode($apiResponse, true));

            $returnResponse = new ReturnResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status code [ReturnAPIBuildR]",
                $returnResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReturnAPIBuildR]",
                $returnResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReturnAPIBuildR]",
                $returnResponse->getdateProcessed());
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReturnAPIBuildR]",
                $returnResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [ReturnAPIBuildR]",
                $returnResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReturnAPIBuildR]",
                $returnResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $returnResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ReturnAPI BuildR",
                $exception->getMessage());
        }
    }

    public static function perform(AuthorizationResponse $authorizationResponse, $testData)
    {
        try {
            $returnRequest = ReturnRequest::newBuilder()
                ->withTransactionId(FrameworkUtils::getTransactionID())
                ->withAccountNumber($authorizationResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withAuthorizationCode($authorizationResponse->getAuthorizationCode())
                ->withSalePerson($testData["SalePerson"])
                ->withTransactionDate(Configuration::getDate())
                ->build();
            $apiResponse = $returnRequest->initiateRequest();

            $returnResponse = new ReturnResponse($apiResponse);
            TestCase::assertEquals($returnResponse->gethttp_status(),
                $testData["StatusCode"],
                "Verification for Status code");
            TestCase::assertEquals($returnResponse->getResponse_description(),
                $testData["Status"],
                "Verification for Status");
            TestCase::assertNotNull($returnResponse->getDateProcessed(), "Verification for DateProcessed");
            TestCase::assertNotNull($returnResponse->getTransactionId(), "Verification for TransactioId");
            TestCase::assertEquals($returnResponse->getTransactionType(),
                $testData["RTransactionType"],
                "Verification for TransactionType");
            TestCase::assertEquals($returnResponse->getAccountNumber(),
                $testData["RAccountNumber"],
                "Verification for AccountNumber");
            return $returnResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Exception Message at ReturnAPI");
        }
    }
}
