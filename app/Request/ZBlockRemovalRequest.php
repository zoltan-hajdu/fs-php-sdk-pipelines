<?php

namespace App\Request;

use App\Builder\ZBlockRemovalBuilder;
use App\Builder\Support\IdBuilder;
use App\Helper\HttpClient;
use App\Request\BaseRequest;

class ZBlockRemovalRequest extends BaseRequest
{
    private string $customerId;
    private string $merchantNumber;
    private string $storeNumber;
    private string $blockCodeType;
    private IdBuilder $Id1;
    private IdBuilder $Id2;
    private $END_POINT = 'retail/customer/accountupdate';

    public function __construct(ZBlockRemovalBuilder $ZBlockRemovalBuilder)
    {
        $this->customerId     = $ZBlockRemovalBuilder->getcustomerId();
        $this->merchantNumber = $ZBlockRemovalBuilder->getmerchantNumber();
        $this->storeNumber    = $ZBlockRemovalBuilder->getstoreNumber();
        $this->blockCodeType  = $ZBlockRemovalBuilder->getblockCodeType();
        $this->Id1            = $ZBlockRemovalBuilder->getId1();
        $this->Id2            = $ZBlockRemovalBuilder->getId2();
    }

    public function initiateRequest(): string
    {
        $transaction_data = [];
        $transaction_data['customerId']     = $this->customerId;
        $transaction_data['merchantNumber'] = $this->merchantNumber;
        $transaction_data['storeNumber']    = $this->storeNumber;
        $transaction_data['blockCodeType']  = $this->blockCodeType;

        if (!empty($this->Id1->getissuerType())) {
            $transaction_data['id1']['issuerType'] = $this->Id1->getissuerType();
        }
        if (!empty($this->Id1->getidType())) {
            $transaction_data['id1']['idType'] = $this->Id1->getidType();
        }
        if (!empty($this->Id1->getprovinceIssued())) {
            $transaction_data['id1']['provinceIssued'] = $this->Id1->getprovinceIssued();
        }
        if (!empty($this->Id1->getexpiryDate())) {
            $transaction_data['id1']['expiryDate'] = $this->Id1->getexpiryDate();
        }
        if (!empty($this->Id1->getaddressVerificationNeeded())) {
            $transaction_data['id1']['addressVerificationNeeded'] = $this->Id1->getaddressVerificationNeeded();
        }
        if (!empty($this->Id1->getaddressDifferentOnAccount())) {
            $transaction_data['id1']['addressDifferentOnAccount'] = $this->Id1->getaddressDifferentOnAccount();
        }
        if (!empty($this->Id1->getidNumber())) {
            $transaction_data['id1']['idNumber'] = $this->Id1->getidNumber();
        }
        if (!empty($this->Id1->getcompanyInstituteName())) {
            $transaction_data['id1']['companyInstituteName'] = $this->Id1->getcompanyInstituteName();
        }
        if (!empty($this->Id1->getmonthYearOfStatement())) {
            $transaction_data['id1']['monthYearOfStatement'] = $this->Id1->getmonthYearOfStatement();
        }


        if (!empty($this->Id2->getissuerType())) {
            $transaction_data['id2']['issuerType'] = $this->Id2->getissuerType();
        }
        if (!empty($this->Id2->getidType())) {
            $transaction_data['id2']['idType'] = $this->Id2->getidType();
        }
        if (!empty($this->Id2->getprovinceIssued())) {
            $transaction_data['id2']['provinceIssued'] = $this->Id2->getprovinceIssued();
        }
        if (!empty($this->Id2->getexpiryDate())) {
            $transaction_data['id2']['expiryDate'] = $this->Id2->getexpiryDate();
        }
        if (!empty($this->Id2->getaddressVerificationNeeded())) {
            $transaction_data['id2']['addressVerificationNeeded'] = $this->Id2->getaddressVerificationNeeded();
        }
        if (!empty($this->Id2->getaddressDifferentOnAccount())) {
            $transaction_data['id2']['addressDifferentOnAccount'] = $this->Id2->getaddressDifferentOnAccount();
        }
        if (!empty($this->Id2->getidNumber())) {
            $transaction_data['id2']['idNumber'] = $this->Id2->getidNumber();
        }
        if (!empty($this->Id2->getcompanyInstituteName())) {
            $transaction_data['id2']['companyInstituteName'] = $this->Id2->getcompanyInstituteName();
        }
        if (!empty($this->Id2->getmonthYearOfStatement())) {
            $transaction_data['id2']['monthYearOfStatement'] = $this->Id2->getmonthYearOfStatement();
        }

        $response = HttpClient::sendRequest('POST', $this->END_POINT, $transaction_data);
        return $response ?: '';
    }

    public static function newBuilder(): ZBlockRemovalBuilder
    {
        return new ZBlockRemovalBuilder();
    }
}
