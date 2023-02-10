<?php

/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\CustomerAccountUpdateRequest;
use App\Request\CustomerSearchRequest;
use App\Response\CustomerAccountUpdateResponse;
use PHPUnit\Framework\TestCase;
use App\Builder\CustomerAccountUpdateBuilder;
use App\Builder\Support\IdBuilder;
use App\Configuration\Configuration;


class CustomerAccUpdateAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $id1 = new IdBuilder();
            $id2 = new IdBuilder();
            $lastMonth = date('m/y', strtotime('first day of previous month'));
            $CustomerAccountUpdate = CustomerAccountUpdateRequest::newBuilder()
                ->withcustomerId('0006030491230006381')
                ->withmerchantNumber('980000450')
                ->withstoreNumber('980000450')
                ->withblockCodeType('Z')
                ->withId1($id1->withissuerType('Primary')
                    ->withidType('Canadian Permanent Resident Card')
                    ->withprovinceIssued('QC')
                    ->withexpiryDate('09/30')
                    ->withaddressVerificationNeeded('y')
                    ->withaddressDifferentOnAccount('n')
                    ->withcompanyInstituteName('Government')
                    ->withidNumber('1234'))
                ->withId2($id2->withissuerType('Secondary')
                    ->withidType('Utility Bill (Current Month)')
                    ->withprovinceIssued('QC')
                    ->withaddressVerificationNeeded('y')
                    ->withaddressDifferentOnAccount('')
                    ->withcompanyInstituteName('HydroQuebec')
                    ->withExpiryDate($lastMonth)
                    ->withidNumber('WXYZ'))
                // ->withId3(
                //                             $id3->withissuerType('')
                //                             ->withidType('')
                //                             ->withprovinceIssued('')
                //                             ->withexpiryDate('')
                //                             ->withaddressVerificationNeeded('')
                //                             ->withaddressDifferentOnAccount('')
                //                             ->withcompanyInstituteName('')
                //                              ->withmonthYearOfStatement('')
                //                             ->withidNumber('')
                //                             )
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("Customer Search", $testData);

            $apiResponse = $CustomerAccountUpdate->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Customer Account Update",
                json_decode($apiResponse, true));

            $customerSearchRespose = new CustomerAccountUpdateResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [CustomerAccUpdateAPI]",
                $customerSearchRespose->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status [CustomerAccUpdateAPI]",
                $customerSearchRespose->getResponse_description(),
                $testData["Status"]);
            $testCaseHandler->assertNotNull("Verification for DateProcessed [CustomerAccUpdateAPI]",
                $customerSearchRespose->getdateProcessed());
            $testCaseHandler->assertEquals("Verification for ResponseCode [CustomerAccUpdateAPI]",
                $customerSearchRespose->getResponseCode(),
                $testData["ResponseCode"]);

            return $customerSearchRespose;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in CustomerAccUpdateAPI",
                $exception->getMessage());
        }
    }
}
