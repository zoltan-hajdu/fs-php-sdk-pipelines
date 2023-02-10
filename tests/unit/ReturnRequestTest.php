<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\ReturnRequest;
use App\Builder\ReturnRequestBuilder;
use App\Configuration\Configuration;

class ReturnRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $returnRequest = ReturnRequest::newBuilder()
            ->withTransactionId('0039100191190013130428')
            ->withAccountNumber('0006030491058065782')
            ->withMerchantNumber('910017093')
            ->withStoreNumber('910019119')
            ->withCreditPlan('14090')
            ->withTransactionType('RETURN')
            ->withTransactionAmount(10.99)
            ->withInvoiceNumber('340')
            ->withAuthorizationCode('090317')
            ->withSalePerson('user123')
            ->withTransactionDate(Configuration::getDate())
            ->build();
        $this->assertContainsOnlyInstancesOf(ReturnRequest::class, [$returnRequest]);
    }
}