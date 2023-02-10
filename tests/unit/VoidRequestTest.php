<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\VoidRequest;
use App\Builder\VoidRequestBuilder;
use App\Configuration\Configuration;

class VoidRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $voidRequest = VoidRequest::newBuilder()
            ->withTransactionId('0039100191190013130427')
            ->withAccountNumber('0006030491058065782')
            ->withMerchantNumber('910017093')
            ->withStoreNumber('910019119')
            ->withCreditPlan('14090')
            ->withTransactionType('VOID')
            ->withAuthorizationCode('090319')
            ->withTransactionAmount(10.99)
            ->withInvoiceNumber('322')
            ->withSalePerson('user123')
            ->withcancelType('SALE')
            ->withTransactionDate(Configuration::getDate())
            ->build();
        $this->assertContainsOnlyInstancesOf(VoidRequest::class, [$voidRequest]);
    }
}