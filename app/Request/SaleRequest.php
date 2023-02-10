<?php
//define SaleRequest class
namespace App\Request;

use App\Builder\SaleRequestBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class SaleRequest extends BaseRequest
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
    ////Version 2.0
    private string $lookupType;
    private string $idType;
    private string $idNumber;
    private string $provinceOfIssue;
    private string $expiryDate;
    private string $addressDifferentFromAccount;
    //version 3.0
    private string $OTP;
    private string $END_POINT = 'retail/transaction';

    public function __construct(SaleRequestBuilder $saleRequestBuilder)
    {
        $this->transactionId = $saleRequestBuilder->getTransactionId();
        $this->accountNumber = $saleRequestBuilder->getAccountNumber();
        $this->merchantNumber = $saleRequestBuilder->getMerchantNumber();
        $this->storeNumber = $saleRequestBuilder->getStoreNumber();
        $this->creditPlan = $saleRequestBuilder->getCreditPlan();
        $this->transactionType = $saleRequestBuilder->getTransactionType();
        $this->transactionAmount = $saleRequestBuilder->getTransactionAmount();
        $this->invoiceNumber = $saleRequestBuilder->getInvoiceNumber();

        if ($saleRequestBuilder->getauthorizationCode() != null) {
            $this->authorizationCode = $saleRequestBuilder->getauthorizationCode();
        }
        $this->salePerson = $saleRequestBuilder->getSalePerson();
        $this->transactionDate = $saleRequestBuilder->getTransactionDate();
        ///version 2.0
        if ($saleRequestBuilder->getlookupType() != null) {
            $this->lookupType = $saleRequestBuilder->getlookupType();
        }
        if ($saleRequestBuilder->getidType() != null) {
            $this->idType = $saleRequestBuilder->getidType();
        }
        if ($saleRequestBuilder->getidNumber() != null) {
            $this->idNumber = $saleRequestBuilder->getidNumber();
        }
        if ($saleRequestBuilder->getprovinceOfIssue() != null) {
            $this->provinceOfIssue = $saleRequestBuilder->getprovinceOfIssue();
        }
        if ($saleRequestBuilder->getexpiryDate() != null) {
            $this->expiryDate = $saleRequestBuilder->getexpiryDate();
        }
        if ($saleRequestBuilder->getaddressDifferentFromAccount() != null) {
            $this->addressDifferentFromAccount = $saleRequestBuilder->getaddressDifferentFromAccount();
        }
        //version 3.0
        if ($saleRequestBuilder->getOTP() != null) {
            $this->OTP = $saleRequestBuilder->getOTP();
        }
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['accountNumber'] = $this->accountNumber;
        $transaction_data['creditPlan'] = $this->creditPlan;
        $transaction_data['invoiceNumber'] = $this->invoiceNumber;
        $transaction_data['merchantNumber'] = $this->merchantNumber;
        $transaction_data['salePerson'] = $this->salePerson;
        $transaction_data['storeNumber'] = $this->storeNumber;
        $transaction_data['transactionAmount'] = number_format((float)$this->transactionAmount, 2, '.', '');
        $transaction_data['transactionDate'] = $this->transactionDate;
        $transaction_data['transactionId'] = $this->transactionId;
        $transaction_data['transactionType'] = $this->transactionType;

        if (isset($this->authorizationCode)) {
            $transaction_data['authorizationCode'] = $this->authorizationCode;
        }
        if (isset($this->lookupType)) {
            $transaction_data['lookupType'] = $this->lookupType;
        }
        if (isset($this->idType)) {
            $transaction_data['idType'] = $this->idType;
        }
        if (isset($this->idNumber)) {
            $transaction_data['idNumber'] = $this->idNumber;
        }
        if (isset($this->provinceOfIssue)) {
            $transaction_data['provinceOfIssue'] = $this->provinceOfIssue;
        }
        if (isset($this->expiryDate)) {
            $transaction_data['expiryDate'] = $this->expiryDate;
        }
        if (isset($this->addressDifferentFromAccount)) {
            $transaction_data['addressDifferentFromAccount'] = $this->addressDifferentFromAccount;
        }
        if (isset($this->OTP)) {
            $transaction_data['OTP'] = $this->OTP;
        }

        ///log
        $transaction_data_logger = array();
        $transaction_data_logger['accountNumber'] = $this->accountNumber;
        $transaction_data_logger['creditPlan'] = $this->creditPlan;
        $transaction_data_logger['invoiceNumber'] = $this->invoiceNumber;
        $transaction_data_logger['merchantNumber'] = $this->merchantNumber;
        $transaction_data_logger['salePerson'] = $this->salePerson;
        $transaction_data_logger['storeNumber'] = $this->storeNumber;
        $transaction_data_logger['transactionAmount'] = number_format((float)$this->transactionAmount, 2, '.', '');
        $transaction_data_logger['transactionDate'] = $this->transactionDate;
        $transaction_data_logger['transactionId'] = $this->transactionId;
        $transaction_data_logger['transactionType'] = $this->transactionType;

        if (isset($this->authorizationCode)) {
            $transaction_data_logger['authorizationCode'] = $this->authorizationCode;
        }
        if (isset($this->lookupType)) {
            $transaction_data_logger['lookupType'] = $this->lookupType;
        }
        if (isset($this->idType)) {
            $transaction_data_logger['idType'] = $this->idType;
        }
        if (isset($this->idNumber)) {
            $transaction_data_logger['idNumber'] = $this->idNumber;
        }
        if (isset($this->provinceOfIssue)) {
            $transaction_data_logger['provinceOfIssue'] = $this->provinceOfIssue;
        }
        if (isset($this->expiryDate)) {
            $transaction_data_logger['expiryDate'] = $this->expiryDate;
        }
        if (isset($this->addressDifferentFromAccount)) {
            $transaction_data_logger['addressDifferentFromAccount'] = $this->addressDifferentFromAccount;
        }
        if (isset($this->OTP)) {
            $transaction_data_logger['OTP'] = $this->OTP;
        }

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Sales Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): SaleRequestBuilder
    {
        return new SaleRequestBuilder();
    }
}
