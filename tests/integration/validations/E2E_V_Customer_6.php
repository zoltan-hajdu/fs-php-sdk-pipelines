<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/CustomerSearchAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V_Customer_6
{
    public function testValidation($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $testData = $readExcel->getTestData("$spreadSheet.xls", "CustomerSearch", "E2E_V_Customer_6");
        CustomerSearchAPI::build($testData);
    }
}
