<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Builder\GetPaymentPlanBuilder;
use App\Request\GetPaymentPlanRequest;

class GetPaymentPlansTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $getPaymentPlanRequest = GetPaymentPlanRequest::newBuilder()
            ->withAmount(100.50)
            ->withMerchant('3B6B382415C55E08E1B35E1EDA75327646B7B812')
            ->withLang('EN')
            ->withProv('BC')
            ->build();
        $this->assertContainsOnlyInstancesOf(GetPaymentPlanRequest::class, [$getPaymentPlanRequest]);
    }
}