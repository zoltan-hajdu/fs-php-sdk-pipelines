<?php
//define VoidReasponse class
namespace App\Response;

class VoidResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getDateProcessed(): string
    {
        return $this->validate('dateProcessed', $this->response);
    }

    public function getResponseCode(): string
    {
        return $this->validate('responseCode', $this->response);
    }

    public function getTransactionId(): string
    {
        return $this->validate('transactionId', $this->response);
    }

    public function getAccountNumber(): string
    {
        return $this->validate('accountNumber', $this->response);
    }

    public function getDescription(): string
    {
        return $this->validate('description', $this->response);
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
