<?php
//define VoidRequest class
namespace App\Request;

use App\Request\BaseRequest;
use App\Builder\GetPaymentPlanBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;

class GetPaymentPlanRequest extends BaseRequest
{
    private string $amount;
    private string $merchant;
    private string $lang;
    private string $prov;
    private string $END_POINT = 'payment/plans';

    public function __construct(GetPaymentPlanBuilder $getPaymentPlanBuilder)
    {
        $this->amount = $getPaymentPlanBuilder->getAmount();
        $this->merchant = $getPaymentPlanBuilder->getMerchant();
        $this->lang = $getPaymentPlanBuilder->getLang();
        $this->prov = $getPaymentPlanBuilder->getProv();
    }

    public function initiateRequest(): string
    {
        $transaction_data = array(
            'amount' => $this->amount,
            'merchant' => $this->merchant,
            'lang' => $this->lang,
            'prov' => $this->prov
        );
        //Initiate Log file
        $transaction_data_logger = array(
            'amount' => $this->amount,
            'merchant' => $this->merchant,
            'lang' => $this->lang,
            'prov' => $this->prov
        );
        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Get payment plan", $data);

        $response = HttpClient::sendRequest('GET', $this->END_POINT, $transaction_data, 'ECOM');
        return ($response) ? $response : '';
    }

    public static function newBuilder(): GetPaymentPlanBuilder
    {
        return new GetPaymentPlanBuilder();
    }
}
