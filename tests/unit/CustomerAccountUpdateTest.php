<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Request\CustomerAccountUpdateRequest;
use App\Builder\Support\IdBuilder;

//Preparing support builder objects

class CustomerAccountUpdateTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testValidation()
    {
        $id1 = new IdBuilder();
        $id2 = new IdBuilder();
        $id3 = new IdBuilder();
        $CustomerAccountUpdate = CustomerAccountUpdateRequest::newBuilder()
            ->withcustomerId('0006030491058065139')
            ->withmerchantNumber('910017093')
            ->withstoreNumber('910018512')
            ->withblockCodeType('Z')
            ->withId1(
                $id1->withissuerType('Primary') //
                ->withidType('Canadian Permanent Resident Card') //
                ->withprovinceIssued('QC') //
                ->withexpiryDate('09/30')
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
                    ->withidNumber('WXYZ')
            )
            ->build();
        $this->assertContainsOnlyInstancesOf(CustomerAccountUpdateRequest::class, [$CustomerAccountUpdate]);
    }
}