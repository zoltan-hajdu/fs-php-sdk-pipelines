<?php
//define Authorization  Response class
namespace App\Response;

class AuthorizationResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getTransactionId(): string
    {
        return $this->validate('transactionId', $this->response);
    }

    public function getOvv(): string
    {
        return $this->validate('ovv', $this->response);
    }

    public function getResponseCode(): string
    {
        return $this->validate('responseCode', $this->response);
    }

    public function getStatus(): string
    {
        return $this->validate('status', $this->response);
    }

    public function getAuthorizationCode(): string
    {
        return $this->validate('authorizationCode', $this->response);
    }

    public function getAccountNumber(): string
    {
        return $this->validate('accountNumber', $this->response);
    }

    public function getDateProcessed(): string
    {
        return $this->validate('dateProcessed', $this->response);
    }

    public function getTransactionAmount(): string
    {
        return $this->validate('transactionAmount', $this->response);
    }

    public function getIntent(): string
    {
        return $this->validate('intent', $this->response);
    }

    public function getValidUntil(): string
    {
        return $this->validate('valid_until', $this->response);
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
