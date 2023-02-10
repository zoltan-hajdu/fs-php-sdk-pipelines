<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\RetrieveCallIdRequest;
use App\Builder\RetrieveCallIdBuilder;

class RetrieveCallIdTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $retrieveCallIdRequest = RetrieveCallIdRequest::newBuilder()
            ->withCallId('f78086b8766c932b24136a7c1845d7e4a3526314')
            ->build();
        $this->assertContainsOnlyInstancesOf(RetrieveCallIdRequest::class, [$retrieveCallIdRequest]);
    }
}