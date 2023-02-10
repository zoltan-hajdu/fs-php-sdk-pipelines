<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../api/CustomerZBlockRemovalAPI.php');
require_once(__DIR__ . '/../../utils/ReadExcel.php');
require_once(__DIR__ . '/../../utils/ReportHandler.php');

class E2E_PS24_Customer_Z_Block_Removal
{
    public static function test_E2E_PS24($spreadSheet = 'TestData')
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
                "ZBlockRemoval",
                __CLASS__);

            $response = CustomerZBlockRemovalAPI::build($testData);

            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);
            $testRecord = $reportHandler->getTestRecord($startDate, $fileName, $_SESSION['stepData']);
            $testDataStore->insert($testRecord);

            session_destroy();
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] =
                $reportHandler->getErrorData("Exception Message in E2E_PS24_Customer_Z_Block_Removal",
                    $exception->getMessage());
        }
    }
}