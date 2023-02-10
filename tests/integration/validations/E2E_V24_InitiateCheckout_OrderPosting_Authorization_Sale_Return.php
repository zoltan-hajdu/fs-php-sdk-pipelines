<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');

require_once(__DIR__ . '/../../api/OrderPostingAPI.php');

require_once(__DIR__ . '/../../api/AuthorizationAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/ReturnAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return
{
    public function testValidation($spreadSheet = 'TestData')
    {
        try {
            $readExcel = new ReadExcel();
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "InitiateCheckout",
                "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return");
            $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "OrderPosting",
                "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return");
            $orderPostingResponse = OrderpostingAPI::build($initiateCheckoutResponse, $testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "Authorization",
                "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return");
            $saleTestData = $readExcel->getTestData("$spreadSheet.xls",
                "Sale",
                "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return");
            $returnTestData = $readExcel->getTestData("$spreadSheet.xls",
                "Return",
                "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return");
            AuthorizationAPI::forReturn($orderPostingResponse, $testData, $saleTestData, $returnTestData);
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "E2E_V24_InitiateCheckout_OrderPosting_Authorization_Sale_Return ");
        }
    }
}
