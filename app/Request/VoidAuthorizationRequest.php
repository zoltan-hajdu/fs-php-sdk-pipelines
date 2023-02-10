<?php
//define void authorization Request class
namespace App\Request;

use App\Builder\VoidAuthorizationBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\MerchantDetailsBuilder;

class VoidAuthorizationRequest
{
    private string $transactionId;
    private string $intent;
    private MerchantDataBuilder $merchantData;
    private MerchantDetailsBuilder $details;
    private string $END_POINT = 'checkout/authorizations/void';

    public function __construct(VoidAuthorizationBuilder $voidAuthorizationBuilder)
    {
        $this->transactionId = $voidAuthorizationBuilder->getTransactionId();
        $this->intent = $voidAuthorizationBuilder->getIntent();
        $this->merchantData = $voidAuthorizationBuilder->getMerchantData();
        $this->details = $voidAuthorizationBuilder->getDetails();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['transactionId'] = $this->transactionId;
        $transaction_data['intent'] = $this->intent;
        $transaction_data['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        $transaction_data['detail'] = array(
            'merchantNumber' => $this->details->getMerchantNumber(),
            'accountNumber' => $this->details->getAccountNumber(),
            'lastFourDigits' => $this->details->getLastFourDigits(),
            'ovv' => $this->details->getOvv(),
            'authorizationCode' => $this->details->getAuthorizationCode(),
            'creditPlan' => $this->details->getCreditPlan(),
            'amount' => number_format((float)$this->details->getAmount(), 2, '.', ''),
            'description' => $this->details->getDescription()
        );

//Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['transactionId'] = $this->transactionId;
        $transaction_data_logger['intent'] = $this->intent;
        $transaction_data_logger['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        $transaction_data_logger['detail'] = array(
            'merchantNumber' => $this->details->getMerchantNumber(),
            'lastFourDigits' => $this->details->getLastFourDigits(),
            'ovv' => $this->details->getOvv(),
            'authorizationCode' => $this->details->getAuthorizationCode(),
            'creditPlan' => $this->details->getCreditPlan(),
            'amount' => number_format((float)$this->details->getAmount(), 2, '.', ''),
            'description' => $this->details->getDescription()
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Void Authorization Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): VoidAuthorizationBuilder
    {
        return new VoidAuthorizationBuilder();
    }
}
