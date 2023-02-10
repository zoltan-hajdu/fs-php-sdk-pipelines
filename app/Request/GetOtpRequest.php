<?php

namespace App\Request;

use App\Builder\GetOtpBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;

class GetOtpRequest extends BaseRequest
{
    private string $accountNumber;
    private string $phoneNumber;
    private $END_POINT = 'retail/customer/getotp';

    public function __construct(GetOtpBuilder $CreateOtpBuilder)
    {
        $this->accountNumber = $CreateOtpBuilder->getAccountNumber();
        $this->phoneNumber = $CreateOtpBuilder->getPhoneNumber();
    }

    public function initiateRequest(): string
    {
        $transaction_data = [];
        $transaction_data['accountNumber'] = $this->accountNumber;
        $transaction_data['phoneNumber'] = $this->phoneNumber;

        //Initiate Log file
        $transaction_data_logger = [];
        $transaction_data_logger['accountNumber'] = $this->accountNumber;
        $transaction_data_logger['phoneNumber'] = $this->phoneNumber;

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Get Otp Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return $response ?: '';
    }

    public static function newBuilder(): GetOtpBuilder
    {
        return new GetOtpBuilder();
    }
}
