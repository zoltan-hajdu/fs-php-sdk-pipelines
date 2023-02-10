<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\InitiateCheckoutRequest;
use App\Builder\InitiateCheckoutBuilder;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\RedirectUrlsBuilder;
use App\Configuration\Configuration;

class InitiateCheckoutTest extends \Codeception\Test\Unit
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
        $customerData = new CustomerDataBuilder();
        $redirectUrls = new RedirectUrlsBuilder();
        $initiateCheckout = InitiateCheckoutRequest::newBuilder()
            ->withIntent('initiate')
            ->withMerchantData(
                $merchantData->withPaymentGatewayId('3B6B382415C55E08E1B35E1EDA75327646B7B812')
                    ->withMerchantNumber('910017093')
                    ->withStoreNumber('910017093')
                    ->withSource('ECOM')
            )
            ->withLastFourDigits('1221')
            ->withCustomerData(
                $customerData->withCustomerFirstName('Test')
                    ->withCustomerEmail('ezechiel.marcellin.koukpode@fairstone.ca')
                    ->withCustomerLastName('Tester')
            )
            ->withCreationTimeStamp(time())
            ->withBillingAddress(
                $billingAddress->withPersonName('Test Tester')
                    ->withFirstName('Test')
                    ->withLastName('Tester')
                    ->withLine1('Some Place Else')
                    ->withCity('Test City')
                    ->withStateProvinceCode('ON')
                    ->withPostalCode('N5R0L2')
                    ->withCountryCode('CA')
            )
            ->withShippingAddress(
                $shippingAddress->withPersonName('Test Tester')
                    ->withFirstName('Test')
                    ->withLastName('Tester')
                    ->withLine1('Some Place Else')
                    ->withCity('Test City')
                    ->withStateProvinceCode('ON')
                    ->withPostalCode('N5R0L2')
                    ->withCountryCode('CA')
            )
            ->withTotalAmount(50.00)
            ->withCurrency('CAD')
            ->withRedirectUrls(
                $redirectUrls->withFailureUrl("https://merchantsite.com/failure")
                    ->withCancelUrl("https://merchantsite.com/cancel")
                    ->withSuccessUrl("https://merchantsite.com/success")

            )
            ->withCallbackUrl("")
            ->withCallbackKey("")
            ->build();
        $this->assertContainsOnlyInstancesOf(InitiateCheckoutRequest::class, [$initiateCheckout]);
    }
}