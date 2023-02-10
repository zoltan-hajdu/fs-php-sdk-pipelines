<?php
//define VoidRequest class
namespace App\Request;

use App\Builder\VoidRequestBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class VoidRequest extends BaseRequest
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $CreditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private string $authorizationCode;
    private string $salePerson;
    private string $transactionDate;
    private string $cancelType;
    private string $END_POINT = 'retail/transaction/cancel';

    public function __construct(VoidRequestBuilder $voidRequestBuilder)
    {
        $this->transactionId = $voidRequestBuilder->getTransactionId();
        $this->accountNumber = $voidRequestBuilder->getAccountNumber();
        $this->merchantNumber = $voidRequestBuilder->getMerchantNumber();
        $this->storeNumber = $voidRequestBuilder->getStoreNumber();
        $this->creditPlan = $voidRequestBuilder->getCreditPlan();
        $this->transactionType = $voidRequestBuilder->getTransactionType();
        $this->transactionAmount = $voidRequestBuilder->getTransactionAmount();
        $this->invoiceNumber = $voidRequestBuilder->getInvoiceNumber();
        $this->authorizationCode = $voidRequestBuilder->getAuthorizationCode();
        $this->salePerson = $voidRequestBuilder->getSalePerson();
        $this->cancelType = $voidRequestBuilder->getCancelType();
        $this->transactionDate = $voidRequestBuilder->getTransactionDate();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array(
            'accountNumber' => $this->accountNumber,
            'creditPlan' => $this->creditPlan,
            'invoiceNumber' => $this->invoiceNumber,
            'merchantNumber' => $this->merchantNumber,
            'salePerson' => $this->salePerson,
            'storeNumber' => $this->storeNumber,
            'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
            'authorizationCode' => $this->authorizationCode,
            'transactionDate' => $this->transactionDate,
            'transactionId' => $this->transactionId,
            'transactionType' => $this->transactionType,
            'cancelType' => $this->cancelType
        );

        //Initiate Log file
        $transaction_data_logger = array(
            'creditPlan' => $this->creditPlan,
            'invoiceNumber' => $this->invoiceNumber,
            'merchantNumber' => $this->merchantNumber,
            'salePerson' => $this->salePerson,
            'storeNumber' => $this->storeNumber,
            'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
            'authorizationCode' => $this->authorizationCode,
            'transactionDate' => $this->transactionDate,
            'transactionId' => $this->transactionId,
            'transactionType' => $this->transactionType,
            'cancelType' => $this->cancelType
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Void Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): VoidRequestBuilder
    {
        return new VoidRequestBuilder();
    }
}
