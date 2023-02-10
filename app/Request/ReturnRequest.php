<?php
//define Return Request class
namespace App\Request;

use App\Builder\ReturnRequestBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class ReturnRequest extends BaseRequest
{
    private string $transactionId;
    private string $accountNumber;
    private string $merchantNumber;
    private string $storeNumber;
    private string $creditPlan;
    private string $transactionType;
    private float $transactionAmount;
    private string $invoiceNumber;
    private string $authorizationCode;
    private string $salePerson;
    private string $transactionDate;
    private $END_POINT = 'retail/transaction';

    public function __construct(ReturnRequestBuilder $returnRequestBuilder)
    {
        $this->transactionId = $returnRequestBuilder->getTransactionId();
        $this->accountNumber = $returnRequestBuilder->getAccountNumber();
        $this->merchantNumber = $returnRequestBuilder->getMerchantNumber();
        $this->storeNumber = $returnRequestBuilder->getStoreNumber();
        $this->creditPlan = $returnRequestBuilder->getCreditPlan();
        $this->transactionType = $returnRequestBuilder->getTransactionType();
        $this->transactionAmount = $returnRequestBuilder->getTransactionAmount();
        $this->invoiceNumber = $returnRequestBuilder->getInvoiceNumber();
        $this->authorizationCode = $returnRequestBuilder->getAuthorizationCode();
        $this->salePerson = $returnRequestBuilder->getSalePerson();
        $this->transactionDate = $returnRequestBuilder->getTransactionDate();
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
            'transactionType' => $this->transactionType
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
            'transactionType' => $this->transactionType
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Return Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): ReturnRequestBuilder
    {
        return new ReturnRequestBuilder();
    }
}
