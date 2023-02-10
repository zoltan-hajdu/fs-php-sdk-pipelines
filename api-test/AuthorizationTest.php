<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\AuthorizationRequest;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\TransactionBuilder;
use App\Builder\Support\DetailsBuilder;
use App\Builder\Support\CustomerId;
use App\Response\AuthorizationResponse;
use App\Configuration\Configuration;

$merchantData = new MerchantDataBuilder();
$transaction = new TransactionBuilder();
$details = new DetailsBuilder();
$CustomerId = new CustomerId();
//Preparing request
$authorizationRequest = AuthorizationRequest::newBuilder()
    ->withTransactionId('29102021091060')
    ->withIntent('authorize')
    ->withOvv('3c9f86b1650f2f6384192af85bd9f0727b8d2a92')
    ->withAccountNumber('0006030491300001569')
    ->withMerchantData(
        $merchantData->withPaymentGatewayId('824B9F3B-D3CC-4A4D-A0C7-9E7B9562D147')
            ->withMerchantNumber('950000000')
            ->withStoreNumber('950000035')
            ->withSource('ECOM')
    )
    ->withLastFourDigits('1221')
    ->withTransaction(
        $transaction->withCreditPlan('13125')
            ->withDetails(
                $details->withItemNumber('25-200ABC')
                    ->withSubTotal(5.00)
            )
            ->withInvoiceNumber('48787589673')
            ->withTotal(10.00)
            ->withTransactionAmount(5.00)
            ->withTransactionDate(Configuration::getDate())
    )
    ->withDescription('AUTH PRODUCT CODE - TV')
    ->withlookupType('Account')
    ->withCustomerId(
        $CustomerId->withidType("Provincial Driver's License")
            ->withidNumber('1556')
            ->withprovinceOfIssue('YT')
            ->withexpiryDate('05/22')
            ->withaddressDifferentFromAccount('y')

    )
    ->build();

//Making HTTP Request and Initializing Response.
if ($authorizationRequest instanceof AuthorizationRequest) {
    $api_response = $authorizationRequest->initiateRequest();
    if ($api_response != '') {
        $response = new AuthorizationResponse($api_response);
        $response->getRAWResponse();
    }
}
