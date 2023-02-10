<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\CustomerSearchRequest;
use App\Response\CustomerSearchResponse;

class CustomerSearchAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $customerSearchRequest = CustomerSearchRequest::newBuilder()
                ->withCustomerId($testData["CustomerID"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Search", $testData);

            $apiResponse = $customerSearchRequest->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Search",
                json_decode($apiResponse, true));

            $customerSearchRespose = new CustomerSearchResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [SaleSearchAPI]",
                $customerSearchRespose->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [SaleSearchAPI]",
                $customerSearchRespose->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [SaleSearchAPI]",
                $customerSearchRespose->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [SaleSearchAPI]",
                $customerSearchRespose->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [SaleSearchAPI]",
                $customerSearchRespose->getAccountNumber(),
                $testData["AccountNumber"]);
            $testCaseHandler->assertEquals("Verification for CustomerName [SaleSearchAPI]",
                $customerSearchRespose->getCustomerName(),
                $testData["CustomerName"]);
            $testCaseHandler->assertEquals("Verification for DOB [SaleSearchAPI]",
                $customerSearchRespose->getDob(),
                $testData["DOB"]);
            $testCaseHandler->assertEquals("Verification for AddressLine1 [SaleSearchAPI]",
                $customerSearchRespose->getAddressLine1(),
                $testData["AddressLine1"]);
            $testCaseHandler->assertEquals("Verification for AddressLine2 [SaleSearchAPI]",
                $customerSearchRespose->getAddressLine2(),
                $testData["AddressLine2"]);
            $testCaseHandler->assertEquals("Verification for PostalCode [SaleSearchAPI]",
                $customerSearchRespose->getPostalCode(),
                $testData["PostalCode"]);
            $testCaseHandler->assertEquals("Verification for City [SaleSearchAPI]",
                $customerSearchRespose->getCity(),
                $testData["City"]);
            $testCaseHandler->assertEquals("Verification for State [SaleSearchAPI]",
                $customerSearchRespose->getState(),
                $testData["State"]);
            $testCaseHandler->assertEquals("Verification for HomePhone [SaleSearchAPI]",
                $customerSearchRespose->getHomePhone(),
                $testData["HomePhone"]);
            $testCaseHandler->assertEquals("Verification for MobilePhone [SaleSearchAPI]",
                $customerSearchRespose->getMobilePhone(),
                $testData["MobilePhone"]);

            return $customerSearchRespose;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in SaleSearchAPI",
                $exception->getMessage());
        }
    }
}
