<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\ReversalRequest;
use App\Builder\ReversalRequestBuilder;
use App\Configuration\Configuration;

class ReversalRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $reversalRequest = ReversalRequest::newBuilder()
            ->withTransactionId('0039100191190013130425')
            ->withAccountNumber('0006030491058065782')
            ->withMerchantNumber('910017093')
            ->withStoreNumber('910019119')
            ->withCreditPlan('14090')
            ->withTransactionType('REVERSAL')
            ->withTransactionAmount(10.99)
            ->withSalePerson('user123')
            ->withcancelType('SALE')
            ->withTransactionDate(Configuration::getDate())
            ->build();
        $this->assertContainsOnlyInstancesOf(ReversalRequest::class, [$reversalRequest]);
    }
}