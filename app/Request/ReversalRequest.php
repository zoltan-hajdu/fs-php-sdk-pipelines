<?php
//define ReversalRequest class
namespace App\Request;

use App\Builder\ReversalRequestBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class ReversalRequest extends BaseRequest
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $creditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private string $salePerson;
    private string $transactionDate;
    private string $cancelType;
    private string $END_POINT = 'retail/transaction/cancel';

    public function __construct(ReversalRequestBuilder $reversalRequestBuilder)
    {
        $this->transactionId = $reversalRequestBuilder->getTransactionId();
        $this->accountNumber = $reversalRequestBuilder->getAccountNumber();
        $this->merchantNumber = $reversalRequestBuilder->getMerchantNumber();
        $this->storeNumber = $reversalRequestBuilder->getStoreNumber();
        $this->creditPlan = $reversalRequestBuilder->getCreditPlan();
        $this->transactionType = $reversalRequestBuilder->getTransactionType();
        $this->transactionAmount = $reversalRequestBuilder->getTransactionAmount();
        $this->invoiceNumber = $reversalRequestBuilder->getInvoiceNumber();
        $this->salePerson = $reversalRequestBuilder->getSalePerson();
        $this->transactionDate = $reversalRequestBuilder->getTransactionDate();
        $this->cancelType = $reversalRequestBuilder->getCancelType();
        if ($reversalRequestBuilder->getauthorizationCode() != null) {
            $this->authorizationCode = $reversalRequestBuilder->getauthorizationCode();
        }
    }

    public function initiateRequest(): string
    {
        if (isset($this->authorizationCode)) {
            $transaction_data = array(
                'accountNumber' => $this->accountNumber,
                'creditPlan' => $this->creditPlan,
                'merchantNumber' => $this->merchantNumber,
                'invoiceNumber' => $this->invoiceNumber,
                'salePerson' => $this->salePerson,
                'storeNumber' => $this->storeNumber,
                'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
                'transactionDate' => $this->transactionDate,
                'transactionId' => $this->transactionId,
                'transactionType' => $this->transactionType,
                'cancelType' => $this->cancelType,
                'authorizationCode' => $this->authorizationCode
            );
        } else {
            $transaction_data = array(
                'accountNumber' => $this->accountNumber,
                'creditPlan' => $this->creditPlan,
                'merchantNumber' => $this->merchantNumber,
                'invoiceNumber' => $this->invoiceNumber,
                'salePerson' => $this->salePerson,
                'storeNumber' => $this->storeNumber,
                'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
                'transactionDate' => $this->transactionDate,
                'transactionId' => $this->transactionId,
                'transactionType' => $this->transactionType,
                'cancelType' => $this->cancelType
            );
        }

        //Initiate Log file
        if (isset($this->authorizationCode)) {
            $transaction_data_logger = array(
                'creditPlan' => $this->creditPlan,
                'merchantNumber' => $this->merchantNumber,
                'invoiceNumber' => $this->invoiceNumber,
                'salePerson' => $this->salePerson,
                'storeNumber' => $this->storeNumber,
                'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
                'transactionDate' => $this->transactionDate,
                'transactionId' => $this->transactionId,
                'transactionType' => $this->transactionType,
                'cancelType' => $this->cancelType,
                'authorizationCode' => $this->authorizationCode
            );
        } else {
            $transaction_data_logger = array(
                'creditPlan' => $this->creditPlan,
                'merchantNumber' => $this->merchantNumber,
                'invoiceNumber' => $this->invoiceNumber,
                'salePerson' => $this->salePerson,
                'storeNumber' => $this->storeNumber,
                'transactionAmount' => number_format((float)$this->transactionAmount, 2, '.', ''),
                'transactionDate' => $this->transactionDate,
                'transactionId' => $this->transactionId,
                'transactionType' => $this->transactionType,
                'cancelType' => $this->cancelType
            );
        }
        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Reversal Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): ReversalRequestBuilder
    {
        return new ReversalRequestBuilder();
    }
}
