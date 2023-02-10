<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Configuration\Configuration;
use App\Request\CreateOtpRequest;
use App\Builder\Support\CreateOtpMerchantDataBuilder;


class CreateOtp extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $merchantData = new CreateOtpMerchantDataBuilder();
        //Preparing request

        $Createotp = CreateOtpRequest::newBuilder()
            ->withaccountNumber('0006030491300001551')
            ->withphoneNumber('7567464654')
            ->withsalePerson('sale 1')
            ->withmerchantData(
                $merchantData->withPaymentGatewayId('0686FFEC-F517-4C13-8989-9B118C54F9F9') //
                ->withMerchantNumber('950000053') //
                ->withStoreNumber('950002062') //
            )
            ->build();
        $this->assertContainsOnlyInstancesOf(CreateOtpRequest::class, [$Createotp]);
        //$this->assertEquals(CreateOtpRequest::class,[$Createotp]);

    }
}