<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\CustomerSearchRequest;
use App\Response\CustomerSearchResponse;

class CustomerSearchWithPhoneAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $customerSearchRequest = CustomerSearchRequest::newBuilder()
                ->withphoneNo($testData["HomePhone"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Search With Phone", $testData);

            $apiResponse = $customerSearchRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Search With Phone",
                json_decode($apiResponse, true));

            $customerSearchResponse = new CustomerSearchResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code",
                $customerSearchResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status",
                $customerSearchResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed",
                $customerSearchResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for AccountNumber",
                $customerSearchResponse->getAccountNumber(),
                $testData["AccountNumber"]);
            $testCaseHandler->assertEquals("Verification for CustomerName",
                $customerSearchResponse->getCustomerName(),
                $testData["CustomerName"]);
            $testCaseHandler->assertEquals("Verification for DOB",
                $customerSearchResponse->getDob(),
                $testData["DOB"]);
            $testCaseHandler->assertEquals("Verification for AddressLine1",
                $customerSearchResponse->getAddressLine1(),
                $testData["AddressLine1"]);
            $testCaseHandler->assertEquals("Verification for AddressLine2",
                $customerSearchResponse->getAddressLine2(),
                $testData["AddressLine2"]);
            $testCaseHandler->assertEquals("Verification for PostalCode",
                $customerSearchResponse->getPostalCode(),
                $testData["PostalCode"]);
            $testCaseHandler->assertEquals("Verification for City",
                $customerSearchResponse->getCity(),
                $testData["City"]);
            $testCaseHandler->assertEquals("Verification for State",
                $customerSearchResponse->getState(),
                $testData["State"]);
            $testCaseHandler->assertEquals("Verification for HomePhone",
                $customerSearchResponse->getHomePhone(),
                $testData["HomePhone"]);
            $testCaseHandler->assertEquals("Verification for MobilePhone",
                $customerSearchResponse->getMobilePhone(),
                $testData["MobilePhone"]);

            return $customerSearchResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in ".__CLASS__,
                $exception->getMessage());
        }
    }
}
