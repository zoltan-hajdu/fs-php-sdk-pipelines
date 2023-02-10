<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/ReturnAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V21_Customer_Sale_Return
{
    public function testValidation($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $testData = $readExcel->getTestData("$spreadSheet.xls", "CustomerSearch", "E2E_V21_Customer_Sale_Return");
        $customerSearchResponse = CustomerSearchAPI::build($testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls", "Sale", "E2E_V21_Customer_Sale_Return");
        $saleResponse = SaleAPI::build($customerSearchResponse, $testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls", "Return", "E2E_V21_Customer_Sale_Return");
        ReturnAPI::buildR($saleResponse, $testData, 0);
    }
}
