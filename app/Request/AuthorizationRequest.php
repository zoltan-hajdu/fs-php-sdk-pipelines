<?php
//define Return Request class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\AuthorizationBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\TransactionBuilder;
use App\Builder\Support\CustomerId;
use App\Helper\HttpClient;
use App\Helper\Logger;


class AuthorizationRequest extends BaseRequest
{
    private string $transactionId;
    private string $intent;
    private string $ovv;
    private string $accountNumber;
    private MerchantDataBuilder $merchantData;
    private string $lastFourDigits;
    private TransactionBuilder $transaction;
    private string $description;
    private string $lookupType;
    private CustomerId $CustomerId;
    private string $END_POINT = 'checkout/authorizations';

    public function __construct(AuthorizationBuilder $authorizationBuilder)
    {
        $this->transactionId = $authorizationBuilder->getTransactionId();
        $this->intent = $authorizationBuilder->getIntent();
        $this->ovv = $authorizationBuilder->getOvv();
        $this->accountNumber = $authorizationBuilder->getAccountNumber();
        $this->merchantData = $authorizationBuilder->getMerchantData();
        if ($authorizationBuilder->getLastFourDigits() != null) {
            $this->lastFourDigits = $authorizationBuilder->getLastFourDigits();
        }
        $this->transaction = $authorizationBuilder->getTransaction();
        $this->description = $authorizationBuilder->getDescription();
        if ($authorizationBuilder->getlookupType() != null) {
            $this->lookupType = $authorizationBuilder->getlookupType();
        }
        if ($authorizationBuilder->getCustomerId() != null) {
            $this->CustomerId = $authorizationBuilder->getCustomerId();
        }
    }

    public static function newBuilder(): AuthorizationBuilder
    {
        return new AuthorizationBuilder();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['transactionId'] = $this->transactionId;
        $transaction_data['intent'] = $this->intent;
        $transaction_data['ovv'] = $this->ovv;
        $transaction_data['accountNumber'] = $this->accountNumber;
        $transaction_data['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        if (isset($this->lastFourDigits)) {
            $transaction_data['lastFourDigits'] = $this->lastFourDigits;
        }
        $transaction_data['transaction'] = array(
            'creditPlan' => $this->transaction->getCreditPlan(),
            'details' => array(),
            'invoiceNumber' => $this->transaction->getInvoiceNumber(),
            'total' => number_format((float)$this->transaction->getTotal(), 2, '.', ''),
            'transactionAmount' => number_format((float)$this->transaction->getTransactionAmount(), 2, '.', ''),
            'transactionDate' => $this->transaction->getTransactionDate()
        );
        $transaction_data['transaction']['details']['items'] = array();
        foreach ($this->transaction->getDetails() as $detail) {
            $transaction_data['transaction']['details']['items'][] = array(
                'itemNumber' => $detail->getItemNumber(),
                'subTotal' => number_format((float)$detail->getSubTotal(), 2, '.', ''),
            );
        }
        $transaction_data['description'] = $this->description;
        if (isset($this->lookupType)) {
            $transaction_data['lookupType'] = $this->lookupType;
        }
        if (isset($this->CustomerId)) {
            $transaction_data['CustomerId'] = array();
            $transaction_data['CustomerId']['idType'] = $this->CustomerId->getidType();
            $transaction_data['CustomerId']['idNumber'] = $this->CustomerId->getidNumber();
            $transaction_data['CustomerId']['provinceOfIssue'] = $this->CustomerId->getprovinceOfIssue();
            $transaction_data['CustomerId']['expiryDate'] = $this->CustomerId->getexpiryDate();
            $transaction_data['CustomerId']['addressDifferentFromAccount'] =
                $this->CustomerId->getaddressDifferentFromAccount();
        }

//Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['transactionId'] = $this->transactionId;
        $transaction_data_logger['intent'] = $this->intent;
        $transaction_data_logger['ovv'] = $this->ovv;
        $transaction_data_logger['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        if (isset($this->lastFourDigits)) {
            $transaction_data_logger['lastFourDigits'] = $this->lastFourDigits;
        }
        $transaction_data_logger['transaction'] = array(
            'creditPlan' => $this->transaction->getCreditPlan(),
            'details' => array(),
            'invoiceNumber' => $this->transaction->getInvoiceNumber(),
            'total' => number_format((float)$this->transaction->getTotal(), 2, '.', ''),
            'transactionAmount' => number_format((float)$this->transaction->getTransactionAmount(), 2, '.', ''),
            'transactionDate' => $this->transaction->getTransactionDate()
        );
        $transaction_data_logger['transaction']['details']['items'] = array();
        foreach ($this->transaction->getDetails() as $detail) {
            $transaction_data_logger['transaction']['details']['items'][] = array(
                'itemNumber' => $detail->getItemNumber(),
                'subTotal' => number_format((float)$detail->getSubTotal(), 2, '.', ''),
            );
        }
        $transaction_data_logger['description'] = $this->description;
        if (isset($this->lookupType)) {
            $transaction_data_logger['lookupType'] = $this->lookupType;
        }
        if (isset($this->CustomerId)) {
            $transaction_data_logger['CustomerId'] = array();
            $transaction_data_logger['CustomerId']['idType'] = $this->CustomerId->getidType();
            $transaction_data_logger['CustomerId']['idNumber'] = $this->CustomerId->getidNumber();
            $transaction_data_logger['CustomerId']['provinceOfIssue'] = $this->CustomerId->getprovinceOfIssue();
            $transaction_data_logger['CustomerId']['expiryDate'] = $this->CustomerId->getexpiryDate();
            $transaction_data_logger['CustomerId']['addressDifferentFromAccount'] =
                $this->CustomerId->getaddressDifferentFromAccount();
        }
        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Authorization Request", $data);

        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }
}
