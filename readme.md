# New features on SDK 2.0
## Sales API
---
1. Added a new attribute called "Lookup type" in Sales API
    * If the Lookup type is Barcode then it will be  "Barcode based search"
    * If the lookup type is Account  then it will be  "Account based search"
    * If the lookup type is not populated and auth code is attached in request, check for auth code in DB to validate if it's a valid one. 

2. Added customer ID information through sales API call , so that the captured customer ID can be relayed to Vision+.

3. Added new attribute idType, provinceOfIssue, expiryDate, idNumber,  addressDifferentFromAccount which is not mandatory 

```
 ->withlookupType('account') 
					->withidNumber('1234')
					->withidType("DriverLicense")
					->withprovinceOfIssue('QC') 
					->withexpiryDate('10/25')
					->withaddressDifferentFromAccount('y') 
					
```
## Reversal api
---
* Reversal API for a SALE just requires the type of transaction that needs to be reversed, transactionID [of the original transaction that needs to be reversed], creditPlan and transactionAmount. For a RETURN it also requires the authorizationCode and the transactionDate(only the date).
  Check function 
  ```
  ->withcancelType('RETURN') and ->withAuthorizationCode('040203')
  ```
   and it is not mandatory filed when required it will be applied.

   ## Get ID type List
   ---
   Get ID Type List API is a POST request to retrieve a list of id types available for the issuerType (Primary/Secondary) with a specified language (English/French) and customer’s address province. This API is to retrieve a list of available ID types for a certain issuer type for merchant development team to prepare dropdown list needed to input ID verification info upon z-block removal or sales transaction request.
   ```
   $getidTypelistRequest=GetidTypelistRequest::newBuilder()
		->withissuerType('Primary')
		->withcustomerProvince('QC')
		->build();					
    if($getidTypelistRequest instanceof GetidTypelistRequest){
	$api_response=$getidTypelistRequest->initiateRequest();
	if($api_response!=''){
		$response=new GetidTypelistResponse($api_response);
		$response->getRAWResponse(); 
	}
    }	
    ```
    ## Customer Account Update
    ---
    Customer Account Update API is a POST request to update customer account zblock field to empty based on Barcode id (or) account number [when client staff enters full account number using pin pad]. As per OWASP recommendation we do not want to include the account number details in customer systems request logs. Due to above mentioned recommendation, it is mandated to have the body payload in which id value will be passed. Due to this guideline, we expose POST API to retrieve customer details based on body payload.  Customer Z-Block Removal API call adheres to the HMAC signature logic as like any other POST API call in this documentation. This API is to validate customer account number and remove zblock field.  POS client staff person can unblock a customer’s account zblock. 

    ```
    $CustomerAccountUpdate=CustomerAccountUpdateRequest::newBuilder()
	->withcustomerId('0006030491058065139')
    ->withmerchantNumber('910017093')
    ->withstoreNumber('910018512')
    ->withblockCodeType('Z')
	->withId1(
        $id1->withissuerType('Primary') 
		->withidType('Canadian Permanent Resident Card') 
		->withprovinceIssued('QC') 
		->withexpiryDate('09/21')
        ->withaddressVerificationNeeded('y') 
        ->withaddressDifferentOnAccount('n')
        ->withcompanyInstituteName('Government')
        ->withidNumber('1234') 
            )
        ->withId2(
        $id2->withissuerType('Secondary') 
		->withidType('Utility Bill (Current Month')
		->withprovinceIssued('QC')
        ->withaddressVerificationNeeded('y')
        ->withaddressDifferentOnAccount('')
        ->withcompanyInstituteName('HydroQuebec')
        ->withmonthYearOfStatement('08/21')
        ->withidNumber('WXYZ')                                          
		->build();	
    if($CustomerAccountUpdate instanceof CustomerAccountUpdateRequest){
	$api_response=$CustomerAccountUpdate->initiateRequest();
	if($api_response!=''){
		$response=new CustomerAccountUpdateResponse($api_response);
		$response->getRAWResponse();
	}
    }

## Authorization API
___
1. Added  new attribute "Lookup type" in Authorization API

2. Possible Values: “Account”, “Barcode” If present, specifies the type of search that is being provided.

3. Added customer ID information through Authorization API call 

4. If customerID exits  it  should contain at least idType and idNumber else you can remove 

* extra fields

->withlookupType('Account')

->withCustomerId(
$CustomerId->withidType("Provincial Driver's License")

->withidNumber('1556')

->withprovinceOfIssue('YT')

->withexpiryDate('05/22')

->withaddressDifferentFromAccount('y')
)


### Added gethttp_status on response field for Httpstatus on every api response and Status when they are available.