<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');
require_once(__DIR__ . '/../../api/OrderPostingAPI.php');
require_once(__DIR__ . '/../../api/AuthorizationAPI.php');
require_once(__DIR__ . '/../../api/VoidAuthorizationtestAPI.php');
require_once(__DIR__ . '/../../utils/ReadExcel.php');
require_once(__DIR__ . '/../../utils/ReportHandler.php');

class E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization
{
    public static function test_E2E_PS08($spreadSheet = 'TestData')
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
                "InitiateCheckout",
                "E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");

            $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);

            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "OrderPosting",
                "E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");

            $orderPostingResponse = !is_null($initiateCheckoutResponse) ?
                OrderpostingAPI::build($initiateCheckoutResponse, $testData) : null;

            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "Authorization",
                "E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
            $voidTestData = $readExcel->getTestData("$spreadSheet.xls",
                "VoidAuthorization",
                "E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");

            if (!is_null($orderPostingResponse)) {
                AuthorizationAPI::forVoidAuthorization($orderPostingResponse, $testData, $voidTestData);
            }

            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);
            $testRecord = $reportHandler->getTestRecord($startDate, $fileName, $_SESSION['stepData']);
            $testDataStore->insert($testRecord);

            session_destroy();
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] =
                $reportHandler->getErrorData("Exception Message in E2E_PS08_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization",
                    $exception->getMessage());
        }
    }
}
