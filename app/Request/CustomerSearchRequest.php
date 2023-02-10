<?php
//define CustomerSearch Request class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\CustomerSearchBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;

class CustomerSearchRequest extends BaseRequest
{
    private string $customerId;
    private string $merchantNumber;
    private string $storeNumber;
    //3.0 SDK
    private string $phoneNo;
    private string $firstName;
    private string $lastName;
    private string $postalCode;
    private string $END_POINT = 'retail/customer';

    public function __construct(CustomerSearchBuilder $customerSearchBuilder)
    {
        if ($customerSearchBuilder->getCustomerId() != null) {
            $this->customerId = $customerSearchBuilder->getCustomerId();
        }
        $this->merchantNumber = $customerSearchBuilder->getMerchantNumber();
        $this->storeNumber = $customerSearchBuilder->getStoreNumber();
        if ($customerSearchBuilder->getphoneNo() != null) {
            $this->phoneNo = $customerSearchBuilder->getphoneNo();
        }
        if ($customerSearchBuilder->getfirstName() != null) {
            $this->firstName = $customerSearchBuilder->getfirstName();
        }
        if ($customerSearchBuilder->getlastName() != null) {
            $this->lastName = $customerSearchBuilder->getlastName();
        }
        if ($customerSearchBuilder->getpostalCode() != null) {
            $this->postalCode = $customerSearchBuilder->getpostalCode();
        }
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        if (isset($this->customerId)) {
            $transaction_data['customerId'] = $this->customerId;
        }
        $transaction_data['merchantNumber'] = $this->merchantNumber;
        $transaction_data['storeNumber'] = $this->storeNumber;
        if (isset($this->phoneNo)) {
            $transaction_data['phoneNo'] = $this->phoneNo;
        }
        if (isset($this->firstName)) {
            $transaction_data['firstName'] = $this->firstName;
        }
        if (isset($this->lastName)) {
            $transaction_data['lastName'] = $this->lastName;
        }
        if (isset($this->postalCode)) {
            $transaction_data['postalCode'] = $this->postalCode;
        }
        //Initiate Log file
        $transaction_data_logger = array(
            'merchantNumber' => $this->merchantNumber,
            'storeNumber' => $this->storeNumber,
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Customer Search Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): CustomerSearchBuilder
    {
        return new CustomerSearchBuilder();
    }
}
