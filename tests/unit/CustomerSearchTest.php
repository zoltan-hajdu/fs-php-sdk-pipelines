<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\CustomerSearchRequest;
use App\Builder\CustomerSearchBuilder;

class CustomerSearchTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $customerSearchRequest = CustomerSearchRequest::newBuilder()
            ->withCustomerId('0006030491058066434')
            ->withMerchantNumber('910017093')
            ->withStoreNumber('910017093')
            ->build();
        $this->assertContainsOnlyInstancesOf(CustomerSearchRequest::class, [$customerSearchRequest]);
    }
}