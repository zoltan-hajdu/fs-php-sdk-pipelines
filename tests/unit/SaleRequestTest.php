<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\SaleRequest;
use App\Builder\SaleRequestBuilder;
use App\Configuration\Configuration;

class SaleRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $saleRequest = SaleRequest::newBuilder()
            ->withTransactionId('001910019119001313038202002050098')
            ->withAccountNumber('0006030491058066434')
            ->withMerchantNumber('910019118')
            ->withStoreNumber('910019119')
            ->withCreditPlan('13038')
            ->withTransactionType('SALE')
            ->withTransactionAmount(10.99)
            ->withInvoiceNumber('123')
            ->withSalePerson('user123')
            //->withauthorizationCode('3232')
            ->withTransactionDate(Configuration::getDate())
            //SDK 2.0
            ->withlookupType('account')
            ->withidType('DriverLicense')
            ->withprovinceOfIssue('QC')
            ->withexpiryDate('08/25')
            ->withaddressDifferentFromAccount('y')
            ->withOTP('123456')
            ->build();
        //$this->assertContainsOnlyInstancesOf(SaleRequest::class,[$saleRequest]);
        $this->assertEquals(SaleRequest::class, [$saleRequest]);

    }
}