<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\ZBlockRemovalRequest;
use App\Response\CustomerAccountUpdateResponse;
use App\Builder\Support\IdBuilder;

class CustomerZBlockRemovalAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $id1 = new IdBuilder();
            $id2 = new IdBuilder();

            $primaryIssuerType = $testData['PrimaryIssuerType'] ?? '';
            $id1->withissuerType($primaryIssuerType);

            $primaryIdType = $testData['PrimaryIdType'] ?? '';
            $id1->withidType($primaryIdType);

            $primaryProvinceIssued = $testData['PrimaryProvinceIssued'] ?? '';
            $id1->withprovinceIssued($primaryProvinceIssued);

            $primaryExpiryDate = $testData['PrimaryExpiryDate'] ?? '';
            $id1->withexpiryDate($primaryExpiryDate);

            $primaryAddressVerificationNeeded = $testData['PrimaryAddressVerificationNeeded'] ?? '';
            $id1->withaddressVerificationNeeded($primaryAddressVerificationNeeded);

            $primaryAddressDifferentOnAccount = $testData['PrimaryAddressDifferentOnAccount'] ?? '';
            $id1->withaddressDifferentOnAccount($primaryAddressDifferentOnAccount);

            $primaryIdNumber = $testData['PrimaryIdNumber'] ?? '';
            $id1->withidNumber($primaryIdNumber);

            $primaryCompanyInstituteName = $testData['PrimaryCompanyInstituteName'] ?? '';
            $id1->withcompanyInstituteName($primaryCompanyInstituteName);

            $primaryMonthYearOfStatement = $testData['PrimaryMonthYearOfStatement'] ?? '';
            $id1->withmonthYearOfStatement($primaryMonthYearOfStatement);


            $secondaryIssuerType = $testData['SecondaryIssuerType'] ?? '';
            $id2->withissuerType($secondaryIssuerType);

            $secondaryIdType = $testData['SecondaryIdType'] ?? '';
            $id2->withidType($secondaryIdType);

            $secondaryProvinceIssued = $testData['SecondaryProvinceIssued'] ?? '';
            $id2->withprovinceIssued($secondaryProvinceIssued);

            $secondaryExpiryDate = $testData['SecondaryExpiryDate'] ?? '';
            $id2->withExpiryDate($secondaryExpiryDate);

            $secondaryAddressVerificationNeeded = $testData['SecondaryAddressVerificationNeeded'] ?? '';
            $id2->withaddressVerificationNeeded($secondaryAddressVerificationNeeded);

            $secondaryAddressDifferentOnAccount = $testData['SecondaryAddressDifferentOnAccount'] ?? '';
            $id2->withaddressDifferentOnAccount($secondaryAddressDifferentOnAccount);

            $secondaryIdNumber = $testData['SecondaryIdNumber'] ?? '';
            $id2->withidNumber($secondaryIdNumber);

            $secondaryCompanyInstituteName = $testData['SecondaryCompanyInstituteName'] ?? '';
            $id2->withcompanyInstituteName($secondaryCompanyInstituteName);

            $secondaryMonthYearOfStatement = $testData['SecondaryMonthYearOfStatement'] ?? '';
            $id2->withmonthYearOfStatement($secondaryMonthYearOfStatement);

            $CustomerZBlockRemoval = ZBlockRemovalRequest::newBuilder()
                ->withcustomerId($testData['CustomerID'])
                ->withmerchantNumber($testData['MerchantNumber'])
                ->withstoreNumber($testData['StoreNumber'])
                ->withblockCodeType('Z')
                ->withId1($id1)
                ->withId2($id2)
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Z Block Removal", $testData);
            $apiResponse = $CustomerZBlockRemoval->initiateRequest();

            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Account Update Z Block Removal",
                json_decode($apiResponse, true));

            $customerSearchResponse = new CustomerAccountUpdateResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [CustomerZBlockRemovalAPI]",
                $customerSearchResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [CustomerZBlockRemovalAPI]",
                $customerSearchResponse->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [CustomerZBlockRemovalAPI]",
                $customerSearchResponse->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [CustomerZBlockRemovalAPI]",
                $customerSearchResponse->getResponseCode(),
                $testData["ResponseCode"]);

            return $customerSearchResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in CustomerZBlockRemovalAPI",
                $exception->getMessage());
        }
    }
}
