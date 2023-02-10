<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/FrameworkUtils.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\SaleRequest;
use App\Response\GetOtpResponse;
use App\Response\SaleResponse;
use App\Configuration\Configuration;
use App\Response\CustomerSearchResponse;
use App\Response\AuthorizationResponse;
use PHPUnit\Framework\TestCase;

class SaleAPI
{

    public static function execute($testData)
    {
        try {
            $saleRequest = SaleRequest::newBuilder()
                ->withTransactionId(FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withlookupType($testData['LookupType'])
                ->withidNumber($testData['IDNumber'])
                ->withidType($testData['IDType'])
                ->withprovinceOfIssue($testData['ProvinceOfIssue'])
                ->withexpiryDate($testData['ExpiryDate'])
                ->withaddressDifferentFromAccount($testData['AddressDifferentFromAccount'])
                ->withTransactionDate(Configuration::getDate())
                ->build();
            $apiResponse = $saleRequest->initiateRequest();

            $saleResponse = new SaleResponse($apiResponse);
            TestCase::assertEquals($saleResponse->gethttp_status,
                $testData["StatusCode"],
                "Verification for Status code");
            TestCase::assertEquals($saleResponse->getResponse_description(),
                $testData["Status"],
                "Verification for Status");
            TestCase::assertNotNull($saleResponse->getdateProcessed(), "Verification for DateProcessed");
            TestCase::assertEquals($saleResponse->getResponseCode(),
                $testData["ResponseCode"],
                "Verification for ResponseCode");
//			TestCase::assertNotNull($saleResponse->getAuthorizationCode(), "Verification for AuthorizationCode");
            TestCase::assertNotNull($saleResponse->getTransactionId(), "Verification for TransactionId");
            TestCase::assertEquals($saleResponse->getTransactionType(),
                $testData["RTransactionType"],
                "Verification for TransactionType");
            TestCase::assertEquals($saleResponse->getAccountNumber(),
                $testData["RAccountNumber"],
                "Verification for AccountNumber");
            return $saleResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Failed at Sale");
        }
    }


    public static function build(CustomerSearchResponse $customerSearchResponse, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $saleRequest = SaleRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($customerSearchResponse->getAccountNumber())
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withlookupType($testData['LookupType'])
                ->withidType($testData['IDType'])
                ->withidNumber($testData['IDNumber'])
                ->withprovinceOfIssue($testData['ProvinceOfIssue'])
                ->withexpiryDate($testData['ExpiryDate'])
                ->withaddressDifferentFromAccount($testData['AddressDifferentFromAccount'])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Sale", $testData);

            $apiResponse = $saleRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Sale Build", json_decode($apiResponse, true));

            $saleResponse = new SaleResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [SaleAPIBuild]",
                $saleResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [SaleAPIBuild]",
                $saleResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [SaleAPIBuild]",
                $saleResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [SaleAPIBuild]",
                $saleResponse->getResponseCode(),
                $testData["ResponseCode"]);
//            $testCaseHandler->assertNotNull("Verification for AuthorizationCode [SaleAPIBuild]", $saleResponse->getAuthorizationCode());
            $testCaseHandler->assertNotNull("Verification for TransactionId [SaleAPIBuild]",
                $saleResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [SaleAPIBuild]",
                $saleResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [SaleAPIBuild]",
                $saleResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $saleResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in SaleAPI Build",
                $exception->getMessage());

        }
    }

    public static function perform(AuthorizationResponse $autorizationResponse, $testData, $index)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $saleRequest = SaleRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withAuthorizationCode($testData["AuthorizationCode"] = empty($testData["AuthorizationCode"]) ?
                    $autorizationResponse->getAuthorizationCode() : $testData["AuthorizationCode"])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->withidNumber($testData['IDNumber'])
                ->withlookupType($testData['LookupType'])
                ->withidType($testData['IDType'])
                ->withprovinceOfIssue($testData['ProvinceOfIssue'])
                ->withexpiryDate($testData['ExpiryDate'])
                ->withaddressDifferentFromAccount($testData['AddressDifferentFromAccount'])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Sale", $testData);

            $apiResponse = $saleRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Sale Perform", json_decode($apiResponse, true));

            $saleResponse = new SaleResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status [SaleAPIPerform]",
                $saleResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [SaleAPIPerform]",
                $saleResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [SaleAPIPerform]",
                $saleResponse->getResponseCode(),
                $testData["ResponseCode"]);
//            $testCaseHandler->assertNotNull("Verification for AuthorizationCode [SaleAPIPerform]", $saleResponse->getAuthorizationCode());
            $testCaseHandler->assertNotNull("Verification for TransactionId [SaleAPIPerform]",
                $saleResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [SaleAPIPerform]",
                $saleResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [SaleAPIPerform]",
                $saleResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $saleResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in SaleAPI Perform",
                $exception->getMessage());
        }
    }

    public static function withOTP(GetOtpResponse $getOtpResponse, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $saleRequest = SaleRequest::newBuilder()
                ->withTransactionId($testData["TransactionID"] = FrameworkUtils::getTransactionID())
                ->withAccountNumber($testData["AccountNumber"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->withCreditPlan($testData["CreditPlan"])
                ->withTransactionType($testData["TransactionType"])
                ->withTransactionAmount($testData["TransactionAmount"])
                ->withInvoiceNumber($testData["InvoiceNumber"])
                ->withSalePerson($testData["SalePerson"])
                ->withlookupType($testData['LookupType'])
                ->withidType($testData['IDType'])
                ->withidNumber($testData['IDNumber'])
                ->withprovinceOfIssue($testData['ProvinceOfIssue'])
                ->withexpiryDate($testData['ExpiryDate'])
                ->withaddressDifferentFromAccount($testData['AddressDifferentFromAccount'])
                ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate())
                ->withOTP($getOtpResponse->getPin())
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Sale", $testData);

            $apiResponse = $saleRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Sale Build", json_decode($apiResponse, true));

            $saleResponse = new SaleResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [SaleAPIBuild]",
                $saleResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [SaleAPIBuild]",
                $saleResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [SaleAPIBuild]",
                $saleResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [SaleAPIBuild]",
                $saleResponse->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertNotNull("Verification for TransactionId [SaleAPIBuild]",
                $saleResponse->getTransactionId());
            $testCaseHandler->assertEquals("Verification for RTransactionType [SaleAPIBuild]",
                $saleResponse->getTransactionType(),
                $testData["RTransactionType"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [SaleAPIBuild]",
                $saleResponse->getAccountNumber(),
                $testData["RAccountNumber"]);

            return $saleResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in SaleAPI Build",
                $exception->getMessage());
        }
    }
}
