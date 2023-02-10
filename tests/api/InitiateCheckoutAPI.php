<?php
/* declare(strict_types = 1); */
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');
require_once(__DIR__ . '/../utils/Shellnium/Emulate.php');

use App\Configuration\Configuration;
use App\Request\InitiateCheckoutRequest;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\RedirectUrlsBuilder;
use PHPUnit\Framework\TestCase;

use App\Response\InitiateCheckoutResponse;


class InitiateCheckoutAPI
{
    public static function build($testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        $emulate = new utils\Shellnium\Emulate();

        try {
            $shippingAddress = new AddressBuilder();
            $billingAddress = new AddressBuilder();
            $merchantData = new MerchantDataBuilder();
            $customerData = new CustomerDataBuilder();
            $redirectUrls = new RedirectUrlsBuilder();
            $initiateCheckout = InitiateCheckoutRequest::newBuilder()
                ->withIntent("initiate")
                ->withMerchantData(
                    $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                        ->withMerchantNumber($testData["MerchantNumber"])
                        ->withStoreNumber($testData["StoreNumber"])
                        ->withSource($testData["Source"])
                )
                ->withLastFourDigits($testData["LastFourDigits"])
                ->withCustomerData(
                    $customerData->withCustomerFirstName($testData["CustomerFirstName"])
                        ->withCustomerEmail($testData["CustomerEmail"])
                        ->withCustomerLastName($testData["CustomerLastName"])
                )
                ->withCreationTimeStamp($testData["CreationTimeStamp"] = time())
                ->withBillingAddress(
                    $billingAddress->withPersonName($testData["PersonName"])
                        ->withFirstName($testData["FirstName"])
                        ->withLastName($testData["LastName"])
                        ->withLine1($testData["Line1"])
                        ->withCity($testData["City"])
                        ->withStateProvinceCode($testData["StateProvinceCode"])
                        ->withPostalCode($testData["PostalCode"])
                        ->withCountryCode($testData["CountryCode"])
                )
                ->withShippingAddress(
                    $shippingAddress->withPersonName($testData["PersonName1"])
                        ->withFirstName($testData["FirstName1"])
                        ->withLastName($testData["LastName1"])
                        ->withLine1($testData["Line11"])
                        ->withCity($testData["City1"])
                        ->withStateProvinceCode($testData["StateProvinceCode1"])
                        ->withPostalCode($testData["PostalCode1"])
                        ->withCountryCode($testData["CountryCode1"])
                )
                ->withTotalAmount($testData["TotalAmount"])
                ->withCurrency($testData["Currency"])
                ->withRedirectUrls(
                    $redirectUrls->withFailureUrl($testData["Failure_url"])
                        ->withCancelUrl($testData["Cancel_url"])
                        ->withSuccessUrl($testData["Success_url"])

                )
                ->withCallbackUrl("")
                ->withCallbackKey("")
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("InitiateCheckout", $testData);

            $apiResponse = $initiateCheckout->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Initiate Checkout",
                json_decode($apiResponse, true));

            $initiateCheckoutResponse = new InitiateCheckoutResponse($apiResponse);

            $testCaseHandler->assertEquals("Verification for Status code [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status Description [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getResponse_description(),
                $testData["StatusDescription"]);
            $emulate::run($initiateCheckoutResponse->getLinks()[0]["href"], $testData['AccountNumber']);
            $testCaseHandler->assertNotNull("Verification for CallId [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getCallId());
            $testCaseHandler->assertNotNull("Verification for CreationTimeStamp [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getCreationTimeStamp());
            $testCaseHandler->assertNotNull("Verification for ValidityTimeStamp [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getValidityTimeStamp());
            $testCaseHandler->assertEquals("Verification for Status [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getStatus(),
                $testData["Status"]);
            $testCaseHandler->assertEquals("Verification for Intent [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getIntent(),
                $testData["RIntent"]);
            $testCaseHandler->assertNotNull("Verification for Href [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getLinks()[0]["href"]);
            $testCaseHandler->assertNotNull("Verification for Rel [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getLinks()[0]["rel"]);
            $testCaseHandler->assertNotNull("Verification for Method [InitiateCheckoutAPI]",
                $initiateCheckoutResponse->getLinks()[0]["method"]);

            return $initiateCheckoutResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in [SaleAPI]", $exception->getMessage());
        }
    }

    public static function buildFR($testData)
    {
        $emulate = new utils\Shellnium\Emulate();
        try {
            $shippingAddress = new AddressBuilder();
            $billingAddress = new AddressBuilder();
            $merchantData = new MerchantDataBuilder();
            $customerData = new CustomerDataBuilder();
            $redirectUrls = new RedirectUrlsBuilder();
            $initiateCheckout = InitiateCheckoutRequest::newBuilder()
                ->withIntent("initiate")
                ->withMerchantData(
                    $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                        ->withMerchantNumber($testData["MerchantNumber"])
                        ->withStoreNumber($testData["StoreNumber"])
                        ->withSource($testData["Source"])
                )
                ->withLastFourDigits($testData["LastFourDigits"])
                ->withCustomerData(
                    $customerData->withCustomerFirstName($testData["CustomerFirstName"])
                        ->withCustomerEmail($testData["CustomerEmail"])
                        ->withCustomerLastName($testData["CustomerLastName"])
                )
                ->withCreationTimeStamp(time())
                ->withBillingAddress(
                    $billingAddress->withPersonName($testData["PersonName"])
                        ->withFirstName($testData["FirstName"])
                        ->withLastName($testData["LastName"])
                        ->withLine1($testData["Line1"])
                        ->withCity($testData["City"])
                        ->withStateProvinceCode($testData["StateProvinceCode"])
                        ->withPostalCode($testData["PostalCode"])
                        ->withCountryCode($testData["CountryCode"])
                )
                ->withShippingAddress(
                    $shippingAddress->withPersonName($testData["PersonName1"])
                        ->withFirstName($testData["FirstName1"])
                        ->withLastName($testData["LastName1"])
                        ->withLine1($testData["Line11"])
                        ->withCity($testData["City1"])
                        ->withStateProvinceCode($testData["StateProvinceCode1"])
                        ->withPostalCode($testData["PostalCode1"])
                        ->withCountryCode($testData["CountryCode1"])
                )
                ->withTotalAmount($testData["TotalAmount"])
                ->withCurrency($testData["Currency"])
                ->withRedirectUrls(
                    $redirectUrls->withFailureUrl($testData["Failure_url"])
                        ->withCancelUrl($testData["Cancel_url"])
                        ->withSuccessUrl($testData["Success_url"])

                )
                ->withCallbackUrl("")
                ->withCallbackKey("")
                ->build();
            $apiResponse = $initiateCheckout->initiateRequest();

            $initiateCheckoutResponse = new InitiateCheckoutResponse($apiResponse);
            TestCase::assertEquals($initiateCheckoutResponse->gethttp_status(),
                $testData["StatusCode"],
                "Verification for Status code");
            TestCase::assertEquals($initiateCheckoutResponse->getResponse_description(),
                $testData["StatusDescription"],
                "Verification for Status Description");
            $emulate::run($initiateCheckoutResponse->getLinks()[0]["href"], $testData['AccountNumber']);
            TestCase::assertNotNull($initiateCheckoutResponse->getCallId(), "Verification for CallId");
            TestCase::assertNotNull($initiateCheckoutResponse->getCreationTimeStamp(),
                "Verification for CreationTimeStamp");
            TestCase::assertNotNull($initiateCheckoutResponse->getValidityTimeStamp(),
                "Verification for ValidityTimeStamp");
            TestCase::assertEquals($initiateCheckoutResponse->getStatus(),
                $testData["Status"],
                "Verification for Status");
            TestCase::assertEquals($initiateCheckoutResponse->getIntent(),
                $testData["RIntent"],
                "Verification for Intent");
            TestCase::assertNotNull($initiateCheckoutResponse->getLinks()[0]["href"], "Verification for Href");
            TestCase::assertNotNull($initiateCheckoutResponse->getLinks()[0]["rel"], "Verification for Rel");
            TestCase::assertNotNull($initiateCheckoutResponse->getLinks()[0]["method"], "Verification for Method");
            return $initiateCheckoutResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Failed at InitiateCheckout");
        }
    }
}
