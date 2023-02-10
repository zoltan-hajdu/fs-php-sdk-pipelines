<?php
//define VoidReasponse class
namespace App\Response;

class GetPaymentPlanResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getpaymentPlans(): array
    {
        return $this->validate('paymentPlans', $this->response);
    }

    public function getplanHash($i): string
    {
        return $this->response['paymentPlans'][$i]['planHash'];
    }

    public function getplanCode($i): string
    {
        return $this->response['paymentPlans'][$i]['planCode'];
    }

    public function getadminFeeProductSku($i): string
    {
        return $this->response['paymentPlans'][$i]['adminFeeProductSku'];
    }

    public function getlegalName($i): string
    {
        return $this->response['paymentPlans'][$i]['legalName'];
    }

    public function getdisplayName($i): string
    {
        return $this->response['paymentPlans'][$i]['displayName'];
    }

    public function getshortDescription($i): string
    {
        return $this->response['paymentPlans'][$i]['shortDescription'];
    }

    public function getlongDescription($i): string
    {
        return $this->response['paymentPlans'][$i]['longDescription'];
    }

    public function getterm($i): string
    {
        return $this->response['paymentPlans'][$i]['term'];
    }

    public function getmonthlyPayment($i): string
    {
        return $this->response['paymentPlans'][$i]['monthlyPayment'];
    }

    public function getmonthlyApr($i): string
    {
        return $this->response['paymentPlans'][$i]['monthlyApr'];
    }

    public function gethttp_status(): string
    {
        return $this->validate('response_status', $this->response[0]);
    }

    public function getResponse_description(): string
    {
        return $this->validate('response_description', $this->response[0]);
    }

    public function getRAWResponse(): void
    {
        echo '<pre>';
        print_r($this->response);
        echo '</pre>';
    }
}
