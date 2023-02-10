<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\OrderPostingRequest;

use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\AmountBuilder;
use App\Builder\Support\ItemBuilder;
use App\Response\OrderPostingResponse;

//Preparing builder objects
$shippingAddress = new AddressBuilder();
$billingAddress = new AddressBuilder();
$merchantData = new MerchantDataBuilder();
$amount = new AmountBuilder();
$item = array();
$item = new ItemBuilder();
$item1 = new ItemBuilder();
$customerData = new CustomerDataBuilder();

//Preparing request
$orderPosting = OrderPostingRequest::newBuilder()
    ->withIntent('order')
    ->withCallId('ff499b0de38c3d15de10717dd69ffe5926c61b9e')
    ->withOrderMethod('CC')
    ->withAccountNumber('0006030491300001569')
    ->withMerchantData(

        $merchantData->withPaymentGatewayId('824B9F3B-D3CC-4A4D-A0C7-9E7B9562D147')
            ->withMerchantNumber('950000000')
            ->withStoreNumber('950000035')
            ->withSource('ECOM')
    )
    ->withLastFourDigits('1221')
    ->withCustomerData(
        $customerData->withCustomerFirstName('JEFFREY')
            ->withCustomerEmail('STO-SUPPORT@FAIRSTONE.CA')
            ->withCustomerLastName('YO')
    )
    ->withCreationTimeStamp(time())
    ->withTransactions(

        $amount->withTotal(10.00)
            ->withCurrency('CAD')
            ->withDetails(array($item->withItemBuilder('13090', 5.00), $item1->withItemBuilder('13125', 5.00))

            )
            ->withInvoiceNumber('48787589673')
    )
    ->withBillingAddress(
        $billingAddress->withPersonName('JEFFREY YO')
            ->withFirstName('JEFFREY')
            ->withLastName('YO')
            ->withLine1("1722 RUE D'\''OXFORD")
            ->withCity('SAINT-LAURENT')
            ->withStateProvinceCode('SK')
            ->withPostalCode('S0G4V0')
            ->withCountryCode('CA')
    )
    ->withShippingAddress(
        $shippingAddress->withPersonName('JEFFREY YO')
            ->withFirstName('JEFFREY')
            ->withLastName('YO')
            ->withLine1("1722 RUE D'\''OXFORD")
            ->withCity('SAINT-LAURENT')
            ->withStateProvinceCode('QC')
            ->withPostalCode('G9T5X9')
            ->withCountryCode('CA')
    )
    ->build();


//Making HTTP Request and Initializing Response.
if ($orderPosting instanceof OrderPostingRequest) {
    $api_response = $orderPosting->initiateRequest();
    if ($api_response != '') {
        $response = new OrderPostingResponse($api_response);
        $response->getRAWResponse();
    }
}
