<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');

require_once(__DIR__ . '/../../api/OrderPostingAPI.php');

require_once(__DIR__ . '/../../api/AuthorizationAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/VoidAuthorizationtestAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization
{
    public function testValidation($spreadSheet = 'TestData')
    {
        try {
            $readExcel = new ReadExcel();
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "InitiateCheckout",
                "E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
            $initiateCheckoutResponse = InitiateCheckoutAPI::build($testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "OrderPosting",
                "E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
            $orderPostingResponse = OrderpostingAPI::build($initiateCheckoutResponse, $testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "Authorization",
                "E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
            $voidTestData = $readExcel->getTestData("$spreadSheet.xls",
                "VoidAuthorization",
                "E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
            AuthorizationAPI::forVoidAuthorization($orderPostingResponse, $testData, $voidTestData);
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "E2E_V27_InitiateCheckout_OrderPosting_Authorization_VoidAuthorization");
        }
    }
}
