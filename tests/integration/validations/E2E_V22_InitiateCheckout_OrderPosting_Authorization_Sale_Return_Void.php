<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');

require_once(__DIR__ . '/../../api/OrderPostingAPI.php');

require_once(__DIR__ . '/../../api/AuthorizationAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/ReturnAPI.php');

require_once(__DIR__ . '/../../api/VoidAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void
{
    public function testValidation($spreadSheet = 'TestData')
    {
        try {
            $readExcel = new ReadExcel();
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "InitiateCheckout",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "OrderPosting",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            $orderPostingResponse = OrderpostingAPI::build($initiateCheckoutResponse, $testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "Authorization",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            $saleTestData = $readExcel->getTestData("$spreadSheet.xls",
                "Sale",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            $returnTestData = $readExcel->getTestData("$spreadSheet.xls",
                "Return",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            $voidTestData = $readExcel->getTestData("$spreadSheet.xls",
                "Void",
                "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
            AuthorizationAPI::forVoid($orderPostingResponse, $testData, $saleTestData, $returnTestData, $voidTestData);
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "E2E_V22_InitiateCheckout_OrderPosting_Authorization_Sale_Return_Void");
        }
    }
}
