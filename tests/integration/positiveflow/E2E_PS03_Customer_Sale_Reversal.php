<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');
require_once(__DIR__ . '/../../api/SaleAPI.php');
require_once(__DIR__ . '/../../api/ReversalAPI.php');
require_once(__DIR__ . '/../../utils/ReadExcel.php');
require_once(__DIR__ . '/../../utils/ReportHandler.php');

class E2E_PS03_Customer_Sale_Reversal
{
    public static function test_E2E_PS03($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $reportHandler = new ReportHandler();

        try {
            session_start();

            $startDate = date_create();
            $fileName = $reportHandler->getFileName(__FILE__);
            $testDataStore = $reportHandler->initTestStore();
            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);

            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "CustomerSearch",
                "E2E_PS03_Customer_Sale_Reversal");

            $customerSearchResponse = CustomerSearchAPI::build($testData);

            $testData = $readExcel->getTestData("$spreadSheet.xls", "Sale", "E2E_PS03_Customer_Sale_Reversal");

            $saleResponse = !is_null($customerSearchResponse) ? SaleAPI::build($customerSearchResponse, $testData) :
                null;

            $testData = $readExcel->getTestData("$spreadSheet.xls", "Reversal", "E2E_PS03_Customer_Sale_Reversal");

            if (!is_null($saleResponse)) {
                ReversalAPI::build($saleResponse, $testData, 0);
            }

            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);
            $testRecord = $reportHandler->getTestRecord($startDate, $fileName, $_SESSION['stepData']);
            $testDataStore->insert($testRecord);

            session_destroy();
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] =
                $reportHandler->getErrorData("Exception Message in E2E_PS03_Customer_Sale_Reversal",
                    $exception->getMessage());
        }
    }
}
