<?php
//define get id type list response class
namespace App\Response;

class GetidTypelistResponse extends BaseResponse
{
    private array $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
    }

    public function getidTypeList(): array
    {
        return $this->response['idTypeList'];
    }

    public function getissuerType($i): string
    {
        return $this->response['idTypeList'][$i]['issuerType'];
    }

    public function getidTypeEng($i): string
    {
        return $this->response['idTypeList'][$i]['idTypeEng'];
    }

    public function getidTypeFrench($i): string
    {
        return $this->response['idTypeList'][$i]['idTypeFrench'];
    }

    public function getacceptedProvince($i): string
    {
        return $this->response['idTypeList'][$i]['acceptedProvince'];
    }

    public function getnotes($i): string
    {
        return $this->response['idTypeList'][$i]['notes'];
    }

    public function getshortName($i): string
    {
        return $this->response['idTypeList'][$i]['shortName'];
    }

    public function getrequiredFields($i): string
    {
        return $this->response['idTypeList'][$i]['requiredFields'];
    }

    public function getidNumber($i, $j): string
    {
        return $this->response['idTypeList'][$i]['requiredFields'][$j]['idNumber'];
    }

    public function getcheckAddressMatch($i, $j): string
    {
        return $this->response['idTypeList'][$i]['requiredFields'][$j]['checkAddressMatch'];
    }

    public function getexpiryDate($i, $j): string
    {
        return $this->response['idTypeList'][$i]['requiredFields'][$j]['expiryDate'];
    }

    public function getissuedProvince($i, $j): string
    {
        return $this->response['idTypeList'][$i]['requiredFields'][$j]['issuedProvince'];
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
