<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\OrderPostingRequest;
use App\Builder\OrderPostingBuilder;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\AmountBuilder;
use App\Builder\Support\ItemBuilder;

class OrderPostingTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $shippingAddress = new AddressBuilder();
        $billingAddress = new AddressBuilder();
        $merchantData = new MerchantDataBuilder();
        $amount = new AmountBuilder();
        $item = array();
        $item = new ItemBuilder();
        $customerData = new CustomerDataBuilder();
        $orderPosting = OrderPostingRequest::newBuilder()
            ->withIntent('order')
            ->withCallId('01c024027be102f4660a63fc6b87b9af8d8907b5')
            ->withOrderMethod('CC')
            ->withAccountNumber('0006030491230007090')
            ->withMerchantData(

                $merchantData->withPaymentGatewayId('D9A07D70-FC77-41F0-A057-98D3A4440335')
                    ->withMerchantNumber('980000450')
                    ->withStoreNumber('980000450')
                    ->withSource('ECOM')
            )
            ->withLastFourDigits('1221')
            ->withCustomerData(
                $customerData->withCustomerFirstName('CRIPPEN')
                    ->withCustomerEmail('STO-SUPPORT@FAIRSTONE.CA')
                    ->withCustomerLastName('TESTIDAB')
            )
            ->withCreationTimeStamp(time())
            ->withTransactions(

                $amount->withTotal(50.02)
                    ->withCurrency('CAD')
                    ->withDetails(array($item->withItemBuilder('13038', 25.01), $item->withItemBuilder('13038', 25.01))

                    )
                    ->withInvoiceNumber('48787589673')
            )
            ->withBillingAddress(
                $billingAddress->withPersonName('CRIPPEN TESTIDAB')
                    ->withFirstName('CRIPPEN')
                    ->withLastName('TESTIDAB')
                    ->withLine1('474 BELIVEAU RD E APT 208')
                    ->withCity('WINNIPEG')
                    ->withStateProvinceCode('QC')
                    ->withPostalCode('H8P2A4')
                    ->withCountryCode('CA')
            )
            ->withShippingAddress(
                $shippingAddress->withPersonName('CRIPPEN TESTIDAB')
                    ->withFirstName('CRIPPEN')
                    ->withLastName('TESTIDAB')
                    ->withLine1('474 BELIVEAU RD E APT 208')
                    ->withCity('WINNIPEG')
                    ->withStateProvinceCode('QC')
                    ->withPostalCode('H8P2A4')
                    ->withCountryCode('CA')
            )
            ->build();
        $this->assertContainsOnlyInstancesOf(OrderPostingRequest::class, [$orderPosting]);
    }
}