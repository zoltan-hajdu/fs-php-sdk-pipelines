<?php

namespace App\Response;

class GetOtpResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getPin(): string
    {
        return $this->validate('pin', $this->response);
    }

    public function getPinExpirationTime(): string
    {
        return $this->validate('pinExpirationTime', $this->response);
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
