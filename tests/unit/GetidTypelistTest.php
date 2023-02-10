<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\GetidTypelistRequest;


class GetidTypelistTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $GetidTypelistRequest = GetidTypelistRequest::newBuilder()
            ->withissuerType('Primary')
            ->withcustomerProvince('QC')
            ->build();
        $this->assertContainsOnlyInstancesOf(GetidTypelistRequest::class, [$GetidTypelistRequest]);
    }
}