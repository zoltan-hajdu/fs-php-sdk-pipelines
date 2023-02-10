<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\VoidAuthorizationRequest;
use App\Builder\VoidAuthorizationBuilder;
use App\Configuration\Configuration;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\MerchantDetailsBuilder;

class VoidAuthorizationRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $merchantData = new MerchantDataBuilder();
        $detail = new MerchantDetailsBuilder();
        $voidAuthorizationRequest = VoidAuthorizationRequest::newBuilder()
            ->withtransactionId('003910019119001513038202002050022')
            ->withIntent('void')
            ->withMerchantData(
                $merchantData->withPaymentGatewayId('476b1e5dd190b25d96715e80a70625c13dc206cb41b1067330998cbd85a09001')
                    ->withMerchantNumber('910019118')
                    ->withStoreNumber('910019119')
                    ->withSource('ECOM')
            )
            ->withDetails(
                $detail->withmerchantNumber('910019118')
                    ->withaccountNumber('0006034901234121221')
                    ->withlastFourDigits('1221')
                    ->withovv('9d470a78f2482363fb018ece851d70f9930c3642')
                    ->withauthorizationCode('050005')
                    ->withcreditPlan('13038')
                    ->withamount(200.00)
                    ->withdescription('order item cancelled')
            )
            ->build();
        $this->assertContainsOnlyInstancesOf(VoidAuthorizationRequest::class, [$voidAuthorizationRequest]);
    }
}