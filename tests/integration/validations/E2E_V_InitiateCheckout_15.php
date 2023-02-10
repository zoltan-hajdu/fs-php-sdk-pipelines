<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

require_once(__DIR__ . '/../../api/InitiateCheckoutAPI.php');

require_once(__DIR__ . '/../../utils/ReadExcel.php');

class E2E_V_InitiateCheckout_15
{
    public function testValidation($spreadSheet = 'TestData')
    {
        $readExcel = new ReadExcel();
        $testData = $readExcel->getTestData("$spreadSheet.xls", "InitiateCheckout", "E2E_V_InitiateCheckout_15");
        InitiateCheckoutAPI::build($testData);
    }
}
