<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\CustomerSearchRequest;
use App\Response\CustomerSearchResponse;

class CustomerSearchZBlockApi
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

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Search For Z Block", $testData);

            $apiResponse = $customerSearchRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Search For Z Block",
                json_decode($apiResponse, true));

            $customerSearchRespose = new CustomerSearchResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [CustomerSearchZBlockApi]",
                $customerSearchRespose->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [CustomerSearchZBlockApi]",
                $customerSearchRespose->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [CustomerSearchZBlockApi]",
                $customerSearchRespose->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [CustomerSearchZBlockApi]",
                $customerSearchRespose->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [CustomerSearchZBlockApi]",
                $customerSearchRespose->getAccountNumber(),
                $testData["AccountNumber"]);
            $testCaseHandler->assertEquals("Verification for CustomerName [CustomerSearchZBlockApi]",
                $customerSearchRespose->getCustomerName(),
                $testData["CustomerName"]);
            $testCaseHandler->assertEquals("Verification for DOB [CustomerSearchZBlockApi]",
                $customerSearchRespose->getDob(),
                $testData["DOB"]);
            $testCaseHandler->assertEquals("Verification for AddressLine1 [CustomerSearchZBlockApi]",
                $customerSearchRespose->getAddressLine1(),
                $testData["AddressLine1"]);
            $testCaseHandler->assertEquals("Verification for AddressLine2 [CustomerSearchZBlockApi]",
                $customerSearchRespose->getAddressLine2(),
                $testData["AddressLine2"]);
            $testCaseHandler->assertEquals("Verification for PostalCode [CustomerSearchZBlockApi]",
                $customerSearchRespose->getPostalCode(),
                $testData["PostalCode"]);
            $testCaseHandler->assertEquals("Verification for City [CustomerSearchZBlockApi]",
                $customerSearchRespose->getCity(),
                $testData["City"]);
            $testCaseHandler->assertEquals("Verification for State [CustomerSearchZBlockApi]",
                $customerSearchRespose->getState(),
                $testData["State"]);
            $testCaseHandler->assertEquals("Verification for HomePhone [CustomerSearchZBlockApi]",
                $customerSearchRespose->getHomePhone(),
                $testData["HomePhone"]);
            $testCaseHandler->assertEquals("Verification for MobilePhone [CustomerSearchZBlockApi]",
                $customerSearchRespose->getMobilePhone(),
                $testData["MobilePhone"]);

            return $customerSearchRespose;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in CustomerSearchZBlockApi",
                $exception->getMessage());
        }
    }
}
