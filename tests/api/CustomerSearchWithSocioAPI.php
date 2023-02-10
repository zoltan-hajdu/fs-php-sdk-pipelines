<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\CustomerSearchRequest;
use App\Response\CustomerSearchResponse;

class CustomerSearchWithSocioAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $customerSearchRequest = CustomerSearchRequest::newBuilder()
                ->withfirstName($testData["FirstName"])
                ->withlastName($testData["LastName"])
                ->withpostalCode($testData["PostalCode"])
                ->withphoneNo($testData["HomePhone"])
                ->withMerchantNumber($testData["MerchantNumber"])
                ->withStoreNumber($testData["StoreNumber"])
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Search", $testData);

            $apiResponse = $customerSearchRequest->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Search",
                json_decode($apiResponse, true));

            $customerSearchRespose = new CustomerSearchResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getResponseCode(),
                $testData["ResponseCode"]);
            $testCaseHandler->assertEquals("Verification for AccountNumber [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getAccountNumber(),
                $testData["AccountNumber"]);
            $testCaseHandler->assertEquals("Verification for CustomerName [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getCustomerName(),
                $testData["CustomerName"]);
            $testCaseHandler->assertEquals("Verification for DOB [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getDob(),
                $testData["DOB"]);
            $testCaseHandler->assertEquals("Verification for AddressLine1 [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getAddressLine1(),
                $testData["AddressLine1"]);
            $testCaseHandler->assertEquals("Verification for AddressLine2 [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getAddressLine2(),
                $testData["AddressLine2"]);
            $testCaseHandler->assertEquals("Verification for PostalCode [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getPostalCode(),
                $testData["PostalCode"]);
            $testCaseHandler->assertEquals("Verification for City [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getCity(),
                $testData["City"]);
            $testCaseHandler->assertEquals("Verification for State [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getState(),
                $testData["State"]);
            $testCaseHandler->assertEquals("Verification for HomePhone [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getHomePhone(),
                $testData["HomePhone"]);
            $testCaseHandler->assertEquals("Verification for MobilePhone [CustomerSearchWithSocioAPI]",
                $customerSearchRespose->getMobilePhone(),
                $testData["MobilePhone"]);

            return $customerSearchRespose;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in CustomerSearchWithSocioAPI",
                $exception->getMessage());
        }
    }
}
