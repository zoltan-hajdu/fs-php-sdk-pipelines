<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');

require_once(__DIR__ . '/../../api/SaleAPI.php');

require_once(__DIR__ . '/../../api/VoidAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V_Customer_Sale_Void_9
{
    public function testValidation($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $testData = $readExcel->getTestData("$spreadSheet.xls", "CustomerSearch", "E2E_V_Customer_Sale_Void_9");
        $customerSearchResponse = CustomerSearchAPI::build($testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls", "Sale", "E2E_V_Customer_Sale_Void_9");
        $saleResponse = SaleAPI::build($customerSearchResponse, $testData);
        $testData = $readExcel->getTestData("$spreadSheet.xls", "Void", "E2E_V_Customer_Sale_Void_9");
        VoidAPI::build($saleResponse, $testData);
    }
}
