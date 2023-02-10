<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\SaleRequest;
use App\Response\SaleResponse;
use App\Configuration\Configuration;

$saleRequest = SaleRequest::newBuilder()
    ->withTransactionId('001910019119001313038202002050069')
    ->withAccountNumber('0006030491300001551')
    ->withMerchantNumber('950000053')
    ->withStoreNumber('950002062')
    ->withCreditPlan('12035')
    ->withTransactionType('SALE')
    ->withTransactionAmount(10.00)
    ->withInvoiceNumber('123')
    ->withSalePerson('user123')
    ->withTransactionDate(Configuration::getDate())
    //SDK 2.0
    ->withlookupType('account')
    ->withidNumber('6745')
    ->withidType("DriverLicense")
    ->withprovinceOfIssue('QC')
    ->withexpiryDate('08/25')
    ->withaddressDifferentFromAccount('y')
    // //version 3.0
    ->withOTP('123456')
    ->build();

//Making HTTP Request and Initializing Response.
if ($saleRequest instanceof SaleRequest) {
    $api_response = $saleRequest->initiateRequest();
    if ($api_response != '') {
        $response = new SaleResponse($api_response);
        $response->getRAWResponse();
    }
}
