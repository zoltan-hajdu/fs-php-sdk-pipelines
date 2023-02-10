<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../api/CreateOTPAPI.php');
require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');
require_once(__DIR__ . '/../../api/GetOTPAPI.php');
require_once(__DIR__ . '/../../api/SaleAPI.php');
require_once(__DIR__ . '/../../utils/ReadExcel.php');
require_once(__DIR__ . '/../../utils/ReportHandler.php');

class E2E_PS25_Sale_With_Otp
{
    public static function test_E2E_PS25($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $reportHandler = new ReportHandler();

        try {
            session_start();

            $startDate = date_create();
            $fileName = $reportHandler->getFileName(__FILE__);
            $testDataStore = $reportHandler->initTestStore();
            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);

            $testData = $readExcel->getTestData(
                "$spreadSheet.xls",
                "CreateOTP",
                __CLASS__
            );

            CreateOTPAPI::build($testData);
            $getOtpResponse = GetOTPAPI::build($testData);

            $testData = $readExcel->getTestData("$spreadSheet.xls", "Sale", __CLASS__);

            if (!is_null($getOtpResponse)) {
                SaleAPI::withOTP($getOtpResponse, $testData);
            }

            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);
            $testRecord = $reportHandler->getTestRecord($startDate, $fileName, $_SESSION['stepData']);
            $testDataStore->insert($testRecord);

            session_destroy();
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData(
                "Exception Message in E2E_PS25_Sale_With_Otp",
                $exception->getMessage()
            );
        }
    }
}
