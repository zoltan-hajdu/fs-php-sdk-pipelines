<?php
//define GetidTypelist Request class
namespace App\Request;

use App\Builder\GetidTypelistBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class GetidTypelistRequest extends BaseRequest
{
    private string $issuerType;
    private string $customerProvince;
    private $END_POINT = 'retail/getidtypelist';

    public function __construct(GetidTypelistBuilder $GetidTypelistBuilder)
    {
        if ($GetidTypelistBuilder->getissuerType() != null) {
            $this->issuerType = $GetidTypelistBuilder->getissuerType();
        }
        $this->customerProvince = $GetidTypelistBuilder->getcustomerProvince();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        if (isset($this->issuerType)) {
            $transaction_data['issuerType'] = $this->issuerType;
        }
        $transaction_data['customerProvince'] = $this->customerProvince;

        //Initiate Log file
        $transaction_data_logger = array();
        if (isset($this->issuerType)) {
            $transaction_data_logger['issuerType'] = $this->issuerType;
        }
        $transaction_data_logger['customerProvince'] = $this->customerProvince;

        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Getidtypelist Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): GetidTypelistBuilder
    {
        return new GetidTypelistBuilder();
    }
}
