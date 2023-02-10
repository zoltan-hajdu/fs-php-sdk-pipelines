<?php
//define OrderPosting Reasponse class
namespace App\Response;

class OrderPostingResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getOvv(): string
    {
        return $this->validate('ovv', $this->response);
    }

    public function getCallId(): string
    {
        return $this->validate('callId', $this->response);
    }

    public function getCreationTimeStamp(): string
    {
        return $this->validate('creationTimeStamp', $this->response);
    }

    public function getIntent(): string
    {
        return $this->validate('intent', $this->response);
    }

    public function getStatus(): string
    {
        return $this->validate('status', $this->response);
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
