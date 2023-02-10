<?php
//define CustomerSearch Reasponse class
namespace App\Response;

class CustomerSearchResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getdateProcessed(): string
    {
        return $this->validate('dateProcessed', $this->response);
    }

    public function getResponseCode(): string
    {
        return $this->validate('responseCode', $this->response);
    }

    public function getAccountNumber(): string
    {
        return $this->validate('accountNumber', $this->response);
    }

    public function getCustomerName(): string
    {
        return $this->validate('customerName', $this->response);
    }

    public function getDob(): string
    {
        return $this->validate('dob', $this->response);
    }

    public function getAddressLine1(): string
    {
        return $this->validate('addressLine1', $this->response);
    }

    public function getAddressLine2(): string
    {
        return $this->validate('addressLine2', $this->response);
    }

    public function getpostalCode(): string
    {
        return $this->validate('postalCode', $this->response);
    }

    public function getCity(): string
    {
        return $this->validate('city', $this->response);
    }

    public function getState(): string
    {
        return $this->validate('state', $this->response);
    }

    public function getHomePhone(): string
    {
        return $this->validate('homePhone', $this->response);
    }

    public function getMobilePhone(): string
    {
        return $this->validate('mobilePhone', $this->response);
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
