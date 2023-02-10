<?php
//define Order Posting Request class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\OrderPostingBuilder;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;

class OrderPostingRequest extends BaseRequest
{
    private string $intent;
    private string $callId;
    private string $orderMethod;
    private string $accountNumber;
    private MerchantDataBuilder $merchantData;
    private string $lastFourDigits;
    private CustomerDataBuilder $customerData;
    private int $creationTimeStamp;
    private array $transactions = array();
    private AddressBuilder $billingAddress;
    private AddressBuilder $shippingAddress;
    private $END_POINT = 'checkout/orders';

    public function __construct(OrderPostingBuilder $orderPostingBuilder)
    {
        $this->intent = $orderPostingBuilder->getIntent();
        $this->callId = $orderPostingBuilder->getCallId();
        $this->orderMethod = $orderPostingBuilder->getOrderMethod();
        $this->accountNumber = $orderPostingBuilder->getAccountNumber();
        $this->merchantData = $orderPostingBuilder->getMerchantData();
        $this->lastFourDigits = $orderPostingBuilder->getLastFourDigits();
        $this->customerData = $orderPostingBuilder->getCustomerData();
        $this->creationTimeStamp = $orderPostingBuilder->getCreationTimeStamp();
        $this->transactions = $orderPostingBuilder->getTransactions();
        $this->billingAddress = $orderPostingBuilder->getBillingAddress();
        $this->shippingAddress = $orderPostingBuilder->getShippingAddress();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['intent'] = $this->intent;
        $transaction_data['callId'] = $this->callId;
        $transaction_data['orderMethod'] = $this->orderMethod;
        $transaction_data['accountNumber'] = $this->accountNumber;

        $transaction_data['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        $transaction_data['lastFourDigits'] = $this->lastFourDigits;
        $transaction_data['customerData'] = array(
            'customerFirstName' => $this->customerData->getCustomerFirstName(),
            'customerEmail' => $this->customerData->getCustomerEmail(),
            'customerLastName' => $this->customerData->getCustomerLastName()
        );
        $transaction_data['creationTimeStamp'] = $this->creationTimeStamp;
        $transaction_data['transactions'] = array();
        foreach ($this->transactions as $transaction) {
            $count = count($transaction_data['transactions']);
            $transaction_data['transactions'][$count]['amount'] = array(
                'total' => number_format((float)$transaction->getTotal(), 2, '.', ''),
                'currency' => $transaction->getCurrency(),
                'details' => array()
            );
            $transaction_data['transactions'][$count]['invoiceNumber'] = $transaction->getInvoiceNumber();
            foreach ($transaction->getDetails() as $detail) {
                $transaction_data['transactions'][$count]['amount']['details']['items'][] = array(
                    'creditPlan' => $detail->getCreditPlan(),
                    'subTotal' => number_format((float)$detail->getSubTotal(), 2, '.', '')
                );
            }
        }
        $transaction_data['billingAddress'] = array(
            'personName' => $this->billingAddress->getPersonName(),
            'firstName' => $this->billingAddress->getFirstName(),
            'lastName' => $this->billingAddress->getLastName(),
            'line1' => $this->billingAddress->getLine1(),
            'city' => $this->billingAddress->getCity(),
            'stateProvinceCode' => $this->billingAddress->getStateProvinceCode(),
            'postalCode' => $this->billingAddress->getPostalCode(),
            'countryCode' => $this->billingAddress->getCountryCode()
        );
        $transaction_data['shippingAddress'] = array(
            'personName' => $this->shippingAddress->getPersonName(),
            'firstName' => $this->shippingAddress->getFirstName(),
            'lastName' => $this->shippingAddress->getLastName(),
            'line1' => $this->shippingAddress->getLine1(),
            'city' => $this->shippingAddress->getCity(),
            'stateProvinceCode' => $this->shippingAddress->getStateProvinceCode(),
            'postalCode' => $this->shippingAddress->getPostalCode(),
            'countryCode' => $this->shippingAddress->getCountryCode()
        );

//Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['intent'] = $this->intent;
        $transaction_data_logger['callId'] = $this->callId;
        $transaction_data_logger['orderMethod'] = $this->orderMethod;
        if (isset($this->accountNumber)) {
            $transaction_data_logger['accountNumber'] = $this->accountNumber;
        }
        $transaction_data_logger['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
            'source' => $this->merchantData->getSource()
        );
        $transaction_data_logger['lastFourDigits'] = $this->lastFourDigits;
        $transaction_data_logger['creationTimeStamp'] = $this->creationTimeStamp;
        $transaction_data_logger['transactions'] = array();
        foreach ($this->transactions as $transaction) {
            $count = count($transaction_data_logger['transactions']);
            $transaction_data_logger['transactions'][$count]['amount'] = array(
                'total' => number_format((float)$transaction->getTotal(), 2, '.', ''),
                'currency' => $transaction->getCurrency(),
                'details' => array()
            );
            $transaction_data_logger['transactions'][$count]['invoiceNumber'] = $transaction->getInvoiceNumber();
            foreach ($transaction->getDetails() as $detail) {
                $transaction_data_logger['transactions'][$count]['amount']['details']['items'][] = array(
                    'creditPlan' => $detail->getCreditPlan(),
                    'subTotal' => number_format((float)$detail->getSubTotal(), 2, '.', '')
                );
            }
        }
        $transaction_data_logger['billingAddress'] = array(
            'personName' => $this->billingAddress->getPersonName(),
            'firstName' => $this->billingAddress->getFirstName(),
            'lastName' => $this->billingAddress->getLastName(),
            'line1' => $this->billingAddress->getLine1(),
            'city' => $this->billingAddress->getCity(),
            'stateProvinceCode' => $this->billingAddress->getStateProvinceCode(),
            'postalCode' => $this->billingAddress->getPostalCode(),
            'countryCode' => $this->billingAddress->getCountryCode()
        );
        $transaction_data_logger['shippingAddress'] = array(
            'personName' => $this->shippingAddress->getPersonName(),
            'firstName' => $this->shippingAddress->getFirstName(),
            'lastName' => $this->shippingAddress->getLastName(),
            'line1' => $this->shippingAddress->getLine1(),
            'city' => $this->shippingAddress->getCity(),
            'stateProvinceCode' => $this->shippingAddress->getStateProvinceCode(),
            'postalCode' => $this->shippingAddress->getPostalCode(),
            'countryCode' => $this->shippingAddress->getCountryCode()
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Order Posting Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): OrderPostingBuilder
    {
        return new OrderPostingBuilder();
    }
}
