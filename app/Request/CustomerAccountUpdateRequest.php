<?php
//define CustomerAccountUpdate Request class
namespace App\Request;

use App\Builder\CustomerAccountUpdateBuilder;
use App\Builder\Support\IdBuilder;
use App\Helper\HttpClient;
use App\Helper\Logger;
use App\Request\BaseRequest;

class CustomerAccountUpdateRequest extends BaseRequest
{
    private string $customerId;
    private string $merchantNumber;
    private string $storeNumber;
    private string $blockCodeType;
    private IdBuilder $Id1;
    private IdBuilder $Id2;
    private IdBuilder $Id3;
    private $END_POINT = 'retail/customer/accountupdate';

    public function __construct(CustomerAccountUpdateBuilder $CustomerAccountUpdateBuilder)
    {
        $this->customerId = $CustomerAccountUpdateBuilder->getcustomerId();
        $this->merchantNumber = $CustomerAccountUpdateBuilder->getmerchantNumber();
        $this->storeNumber = $CustomerAccountUpdateBuilder->getstoreNumber();
        $this->blockCodeType = $CustomerAccountUpdateBuilder->getblockCodeType();
        $this->Id1 = $CustomerAccountUpdateBuilder->getId1();
        $this->Id2 = $CustomerAccountUpdateBuilder->getId2();
        if ($CustomerAccountUpdateBuilder->getId3() != null) {
            $this->Id3 = $CustomerAccountUpdateBuilder->getId3();
        }
    }

    public function initiateRequest(): string
    {
        $transaction_data = array();
        $transaction_data['customerId'] = $this->customerId;
        $transaction_data['merchantNumber'] = $this->merchantNumber;
        $transaction_data['storeNumber'] = $this->storeNumber;
        $transaction_data['blockCodeType'] = $this->blockCodeType;
        $transaction_data['id1'] = array(
            'issuerType' => $this->Id1->getissuerType(),
            'idType' => $this->Id1->getidType(),
            'provinceIssued' => $this->Id1->getprovinceIssued(),
            'expiryDate' => $this->Id1->getexpiryDate(),
            'addressVerificationNeeded' => $this->Id1->getaddressVerificationNeeded(),
            'addressDifferentOnAccount' => $this->Id1->getaddressDifferentOnAccount(),
            'idNumber' => $this->Id1->getidNumber(),
            'companyInstituteName' => $this->Id1->getcompanyInstituteName(),
            'monthYearOfStatement' => $this->Id1->getmonthYearOfStatement()
        );
        $transaction_data['id2'] = array(
            'issuerType' => $this->Id2->getissuerType(),
            'idType' => $this->Id2->getidType(),
            'provinceIssued' => $this->Id2->getprovinceIssued(),
            'expiryDate' => $this->Id2->getexpiryDate(),
            'addressVerificationNeeded' => $this->Id2->getaddressVerificationNeeded(),
            'addressDifferentOnAccount' => $this->Id2->getaddressDifferentOnAccount(),
            'idNumber' => $this->Id2->getidNumber(),
            'companyInstituteName' => $this->Id2->getcompanyInstituteName(),
            'monthYearOfStatement' => $this->Id2->getmonthYearOfStatement(),
        );
        if (isset($this->Id3)) {
            $transaction_data['id3'] = array(
                'issuerType' => $this->Id3->getissuerType(),
                'idType' => $this->Id3->getidType(),
                'provinceIssued' => $this->Id3->getprovinceIssued(),
                'expiryDate' => $this->Id3->getexpiryDate(),
                'addressVerificationNeeded' => $this->Id3->getaddressVerificationNeeded(),
                'addressDifferentOnAccount' => $this->Id3->getaddressDifferentOnAccount(),
                'idNumber' => $this->Id3->getidNumber(),
                'companyInstituteName' => $this->Id3->getcompanyInstituteName(),
                'monthYearOfStatement' => $this->Id3->getmonthYearOfStatement(),
            );
        }

//Initiate Log file
        $transaction_data_logger = array();
        $transaction_data_logger['customerId'] = $this->customerId;
        $transaction_data_logger['merchantNumber'] = $this->merchantNumber;
        $transaction_data_logger['storeNumber'] = $this->storeNumber;
        $transaction_data_logger['blockCodeType'] = $this->blockCodeType;
        $transaction_data_logger['id1'] = array(
            'issuerType' => $this->Id1->getissuerType(),
            'idType' => $this->Id1->getidType(),
            'provinceIssued' => $this->Id1->getprovinceIssued(),
            'expiryDate' => $this->Id1->getexpiryDate(),
            'addressVerificationNeeded' => $this->Id1->getaddressVerificationNeeded(),
            'addressDifferentOnAccount' => $this->Id1->getaddressDifferentOnAccount(),
            'idNumber' => $this->Id1->getidNumber(),
            'companyInstituteName' => $this->Id1->getcompanyInstituteName(),
            'monthYearOfStatement' => $this->Id1->getmonthYearOfStatement(),
        );
        $transaction_data_logger['id2'] = array(
            'issuerType' => $this->Id2->getissuerType(),
            'idType' => $this->Id2->getidType(),
            'provinceIssued' => $this->Id2->getprovinceIssued(),
            'expiryDate' => $this->Id2->getexpiryDate(),
            'addressVerificationNeeded' => $this->Id2->getaddressVerificationNeeded(),
            'addressDifferentOnAccount' => $this->Id2->getaddressDifferentOnAccount(),
            'idNumber' => $this->Id2->getidNumber(),
            'companyInstituteName' => $this->Id2->getcompanyInstituteName(),
            'monthYearOfStatement' => $this->Id2->getmonthYearOfStatement(),
        );
        if (isset($this->Id3)) {
            $transaction_data_logger['id3'] = array(
                'issuerType' => $this->Id3->getissuerType(),
                'idType' => $this->Id3->getidType(),
                'provinceIssued' => $this->Id3->getprovinceIssued(),
                'expiryDate' => $this->Id3->getexpiryDate(),
                'addressVerificationNeeded' => $this->Id3->getaddressVerificationNeeded(),
                'addressDifferentOnAccount' => $this->Id3->getaddressDifferentOnAccount(),
                'idNumber' => $this->Id3->getidNumber(),
                'companyInstituteName' => $this->Id3->getcompanyInstituteName(),
                'monthYearOfStatement' => $this->Id3->getmonthYearOfStatement(),
            );
        }


        $data = json_encode($transaction_data_logger);
        Logger::writeLog("Customer Account Update Request", $data);
        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return ($response) ? $response : '';
    }

    public static function newBuilder(): CustomerAccountUpdateBuilder
    {
        return new CustomerAccountUpdateBuilder();
    }
}
