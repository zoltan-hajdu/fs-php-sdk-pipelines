<?php
//define VoidReasponse class
namespace App\Response;

class RetrieveCallIdResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getCallId(): string
    {
        return $this->validate('callId', $this->response);
    }

    public function getStatus(): string
    {
        return $this->validate('status', $this->response);
    }

    public function getAccountNumber(): string
    {
        return $this->validate('accountNumber', $this->response);
    }

    public function getValidityTimeStamp(): string
    {
        return $this->response['validityTimeStamp'];
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
