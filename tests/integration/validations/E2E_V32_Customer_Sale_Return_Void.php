<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/ReturnAPI.php');

require_once(__DIR__ . '/../../api/VoidAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V32_Customer_Sale_Return_Void
{
    public function testValidation($spreadSheet = 'TestData')
    {
        try {
            $readExcel = new ReadExcel();
            $testData = $readExcel->getTestData("$spreadSheet.xls",
                "CustomerSearch",
                "E2E_V32_Customer_Sale_Return_Void");
            $customerSearchResponse = CustomerSearchAPI::build($testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls", "Sale", "E2E_V32_Customer_Sale_Return_Void");
            $saleResponse = SaleAPI::build($customerSearchResponse, $testData);
            $testData = $readExcel->getTestData("$spreadSheet.xls", "Return", "E2E_V32_Customer_Sale_Return_Void");
            ReturnAPI::buildR($saleResponse, $testData, 0);
            $testData = $readExcel->getTestData("$spreadSheet.xls", "Void", "E2E_V32_Customer_Sale_Return_Void");
            VoidAPI::build($saleResponse, $testData);
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "E2E_V32_Customer_Sale_Return_Void");
        }
    }
}
