<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');

require_once(__DIR__ . '/../../api/OrderPostingAPI.php');

require_once(__DIR__ . '/../../api/AuthorizationAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V_InitiateCheckout_OrderPosting_Authorization_Sale_8
{
    public function testValidation($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $testData = $readExcel->getTestData("$spreadSheet.xls",
            "InitiateCheckout",
            "E2E_V_InitiateCheckout_OrderPosting_Authorization_Sale_8");
        $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls",
            "OrderPosting",
            "E2E_V_InitiateCheckout_OrderPosting_Authorization_Sale_8");
        $orderPostingResponse = OrderpostingAPI::build($initiateCheckoutResponse, $testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls",
            "Authorization",
            "E2E_V_InitiateCheckout_OrderPosting_Authorization_Sale_8");
        $saleTestData = $readExcel->getTestData("$spreadSheet.xls",
            "Sale",
            "E2E_V_InitiateCheckout_OrderPosting_Authorization_Sale_8");
        AuthorizationAPI::build($orderPostingResponse, $testData, $saleTestData);
    }
}
