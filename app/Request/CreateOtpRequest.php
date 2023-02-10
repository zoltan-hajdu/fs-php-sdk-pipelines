<?php
//define Create Otp  Request class
namespace App\Request;

use App\Builder\CreateOtpBuilder;
use App\Builder\Support\CreateOtpMerchantDataBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class CreateOtpRequest extends BaseRequest
{
    private CreateOtpMerchantDataBuilder $merchantData;
    private string $accountNumber;
    private string $phoneNumber;
    private string $salePerson;
    private $END_POINT = 'retail/customer/createotp';

    public function __construct(CreateOtpBuilder $CreateOtpBuilder)
    {
        $this->merchantData = $CreateOtpBuilder->getmerchantData();
        $this->accountNumber = $CreateOtpBuilder->getaccountNumber();
        $this->phoneNumber = $CreateOtpBuilder->getphoneNumber();
        $this->salePerson = $CreateOtpBuilder->getsalePerson();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['accountNumber'] = $this->accountNumber;
        $transaction_data['phoneNumber'] = $this->phoneNumber;
        $transaction_data['salePerson'] = $this->salePerson;
        $transaction_data['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
        );

        //Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['accountNumber'] = $this->accountNumber;
        $transaction_data_logger['phoneNumber'] = $this->phoneNumber;
        $transaction_data_logger['salePerson'] = $this->salePerson;
        $transaction_data_logger['merchantData'] = array(
            'paymentGatewayId' => $this->merchantData->getPaymentGatewayId(),
            'merchantNumber' => $this->merchantData->getMerchantNumber(),
            'storeNumber' => $this->merchantData->getStoreNumber(),
        );

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Create Otp Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): CreateOtpBuilder
    {
        return new CreateOtpBuilder();
    }
}
