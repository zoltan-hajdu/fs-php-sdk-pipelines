<?php
/* declare(strict_types = 1); */
require_once('../vendor/autoload.php');

use App\Request\CustomerAccountUpdateRequest;
use App\Builder\Support\IdBuilder;
use App\Response\CustomerAccountUpdateResponse;

//Preparing support builder objects
$id1 = new IdBuilder();
$id2 = new IdBuilder();
$id3 = new IdBuilder();

//Preparing request

$CustomerAccountUpdate = CustomerAccountUpdateRequest::newBuilder()
    ->withcustomerId('0006030491058065139')
    ->withmerchantNumber('910017093')
    ->withstoreNumber('910018512')
    ->withblockCodeType('Z')
    ->withId1(
        $id1->withissuerType('Primary') //
        ->withidType('Canadian Permanent Resident Card') //
        ->withprovinceIssued('QC') //
        ->withexpiryDate('09/21')
            ->withaddressVerificationNeeded('y') //
            ->withaddressDifferentOnAccount('n')
            ->withcompanyInstituteName('Government')
            ->withidNumber('1234') //

    )
    ->withId2(
        $id2->withissuerType('Secondary')
            ->withidType('Utility Bill (Current Month)')
            ->withprovinceIssued('QC')
            ->withaddressVerificationNeeded('y')
            ->withaddressDifferentOnAccount('')
            ->withcompanyInstituteName('HydroQuebec')
            ->withmonthYearOfStatement('08/21')
            ->withidNumber('WXYZ'))
    ->build();
//Making HTTP Request and Initializing Response.
if ($CustomerAccountUpdate instanceof CustomerAccountUpdateRequest) {
    $api_response = $CustomerAccountUpdate->initiateRequest();
    if ($api_response != '') {
        $response = new CustomerAccountUpdateResponse($api_response);
        $response->getRAWResponse();
    }
}
