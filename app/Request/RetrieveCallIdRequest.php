<?php
//define VoidRequest class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\RetrieveCallIdBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Configuration\Configuration;

class RetrieveCallIdRequest extends BaseRequest
{
    private string $callId;
    private string $END_POINT = 'checkout/retrieve/';

    public function __construct(RetrieveCallIdBuilder $retrieveCallIdBuilder)
    {
        $this->callId = $retrieveCallIdBuilder->getCallId();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array(
            'clientId' => Configuration::getClientId(),
            'transEpoch' => Configuration::getEpoch()
        );
        //Initiate Log file
        $transaction_data_logger = array(
            'transEpoch' => Configuration::getEpoch()
        );
        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Retrive call Id", $data);

        $url = $this->END_POINT . $this->callId;
        $response = HttpClient::sendRequest('GET', $url, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): RetrieveCallIdBuilder
    {
        return new RetrieveCallIdBuilder();
    }
}
