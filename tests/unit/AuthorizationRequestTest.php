<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\AuthorizationRequest;
use App\Builder\AuthorizationBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\TransactionBuilder;
use App\Builder\Support\DetailsBuilder;
use App\Configuration\Configuration;

class AuthorizationRequestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $merchantData = new MerchantDataBuilder();
        $transaction = new TransactionBuilder();
        $details = new DetailsBuilder();
        $authorizationRequest = AuthorizationRequest::newBuilder()
            ->withTransactionId('003910019119001513038202746552')
            ->withIntent('authorize')
            ->withOvv('01e6f1ca3788058641c3c373829b4badc805fc50')
            ->withAccountNumber('0006030491058066434')
            ->withMerchantData(
                $merchantData->withPaymentGatewayId('3B6B382415C55E08E1B35E1EDA75327646B7B812')
                    ->withMerchantNumber('910017093')
                    ->withStoreNumber('910017093')
                    ->withSource('ECOM')
            )
            ->withLastFourDigits('1221')
            ->withTransaction(
                $transaction->withCreditPlan('14090')
                    ->withDetails(
                        $details->withItemNumber('25-200ABC')
                            ->withSubTotal(25.00)
                    )
                    ->withInvoiceNumber('123456789012370')
                    ->withTotal(50.00)
                    ->withTransactionAmount(25.00)
                    ->withTransactionDate(Configuration::getDate())
            )
            ->withDescription('AUTH PRODUCT CODE - TV')
            ->build();
        $this->assertContainsOnlyInstancesOf(AuthorizationRequest::class, [$authorizationRequest]);
    }
}