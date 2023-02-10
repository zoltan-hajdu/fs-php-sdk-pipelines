<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../api/GetPaymentPlansAPI.php');
require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');
require_once(__DIR__ . '/../../api/OrderPostingAPI.php');
require_once(__DIR__ . '/../../api/AuthorizationAPI.php');
require_once(__DIR__ . '/../../api/SaleAPI.php');
require_once(__DIR__ . '/../../utils/ReadExcel.php');
require_once(__DIR__ . '/../../utils/ReportHandler.php');

class E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale
{

    public static function test_E2E_PS05($spreadSheet = 'TestData')
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
                "PaymentPlans",
                "E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale");
            $paymentPlansResponse = GetPaymentPlansAPI::build($testData);
            if (!is_null($paymentPlansResponse)) {
                $paymentPlans = $paymentPlansResponse->getpaymentPlans();
                for ($index = 0; $index < count($paymentPlans); $index++) {
                    if ($paymentPlans[$index]['planCode'] != '') {
                        $planCode = $paymentPlans[$index]['planCode'];

                        $testData = $readExcel->getTestData("$spreadSheet.xls",
                            "InitiateCheckout",
                            "E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale");

                        $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);

                        $testData = $readExcel->getTestData("$spreadSheet.xls",
                            "OrderPosting",
                            "E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale");
                        $testData['CreditPlan'] = $planCode;

                        $orderPostingResponse = !is_null($initiateCheckoutResponse) ?
                            OrderpostingAPI::build($initiateCheckoutResponse, $testData) : null;

                        $testData = $readExcel->getTestData("$spreadSheet.xls",
                            "Authorization",
                            "E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale");
                        $testData['CreditPlan'] = $planCode;

                        $saleTestData = $readExcel->getTestData("$spreadSheet.xls",
                            "Sale",
                            "E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale");
                        $testData['CreditPlan'] = $planCode;

                        if (!is_null($orderPostingResponse)) {
                            AuthorizationAPI::build($orderPostingResponse, $testData, $saleTestData);
                        }
                    }
                }
            }
            $_SESSION['stepData'][] = $reportHandler->getInfoData($fileName);
            $testRecord = $reportHandler->getTestRecord($startDate, $fileName, $_SESSION['stepData']);
            $testDataStore->insert($testRecord);

            session_destroy();
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] =
                $reportHandler->getErrorData("Exception Message in E2E_PS05_GetPaymentPlans_InitiateCheckout_OrderPosting_Authorization_Sale",
                    $exception->getMessage());
        }
    }
}
