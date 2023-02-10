<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/FrameworkUtils.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Configuration\Configuration;
use App\Request\ReversalRequest;
use App\Response\ReturnResponse;
use App\Response\AuthorizationResponse;
use App\Response\ReversalResponse;
use App\Response\SaleResponse;

class ReversalAPI
{
    public static function withReversal(ReturnResponse $returnResponse, SaleResponse $saleResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $reversalRequest = ReversalRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $returnResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $returnResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withauthorizationCode($testData["AuthorizationCode"] = $saleResponse->getAuthorizationCode())
                ->withInvoiceNumber($testData['InvoiceNumber'])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Reversal", $testData);

            $apiResponse = $reversalRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Reversal With Reversal",
                json_decode($apiResponse, true));

            $reversalResponse = new ReversalResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReversalAPIBuild]. Method: withReversal",
                $reversalResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $reversalResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] =
                $reportHandler->getErrorData("Exception in ReversalAPIWithReversal. Method: withReversal",
                    $exception->getMessage());
        }
    }

    public static function build(SaleResponse $saleResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $reversalRequest = ReversalRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $saleResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Reversal", $testData);

            $apiResponse = $reversalRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Reversal Build",
                json_decode($apiResponse, true));

            $reversalResponse = new ReversalResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [ReversalAPIBuild]. Method: build",
                $reversalResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReversalAPIBuild]. Method: build",
                $reversalResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReversalAPIBuild]. Method: build",
                $reversalResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [ReversalAPIBuild]. Method: build",
                $reversalResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReversalAPIBuild]. Method: build",
                $reversalResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReversalAPIBuild]. Method: build",
                $reversalResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $reversalResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ReversalAPIBuild. Method: build",
                $exception->getMessage());
        }
    }

    public static function forSale(AuthorizationResponse $authorizationResponse, SaleResponse $saleResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $reversalRequest = ReversalRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = $saleResponse->getTransactionId())
                ->withAccountNumber($testData["AccountNumber"] = $saleResponse->getAccountNumber())
                ->withauthorizationCode($testData["AuthorizationCode"] = $authorizationResponse->getAuthorizationCode())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withcancelType($testData["CancelType"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Reversal", $testData);

            $apiResponse = $reversalRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Reversal Build",
                json_decode($apiResponse, true));

            $reversalResponse = new ReversalResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for AccountNumber [ReversalAPIBuild]. Method: forSale",
                $reversalResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $reversalResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ReversalAPIBuild. Method: forSale",
                $exception->getMessage());
        }
    }
}
