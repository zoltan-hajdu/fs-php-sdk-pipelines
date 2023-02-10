<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');

use App\Request\OrderPostingRequest;
use App\Builder\Support\AddressBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\CustomerDataBuilder;
use App\Builder\Support\AmountBuilder;
use App\Builder\Support\ItemBuilder;
use App\Response\OrderPostingResponse;
use App\Response\InitiateCheckoutResponse;
use Respect\Validation\Rules\ArrayType;

class OrderpostingAPI
{

    public static function build(InitiateCheckoutResponse $initiateCheckoutResponse, $testData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();
        try {
            $shippingAddress = new AddressBuilder();
            $billingAddress = new AddressBuilder();
            $merchantData = new MerchantDataBuilder();
            $amount = new AmountBuilder();
            $itemsCount = count(explode(",", $testData["CreditPlan"]));
            $data = array();
            //$items = new ItemBuilder();
            for ($index = 0; $index < $itemsCount; $index++) {
                $items = new ItemBuilder();
                $items->withItemBuilder(explode(",", $testData["CreditPlan"])[$index],
                    explode(",", $testData["SubTotal"])[$index]);
                $data[] = $items;
            }
            $customerData = new CustomerDataBuilder();
            $orderPosting = OrderPostingRequest::newBuilder()
                ->withIntent($testData["Intent"])
                ->withCallId($testData["CallId"] = $initiateCheckoutResponse->getCallId())
                ->withOrderMethod($testData["OrderMethod"])
                ->withAccountNumber($testData["AccountNumber"])
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
                ->withTransactions(
                    $amount->withTotal($testData["Total"])
                        ->withCurrency($testData["Currency"])
                        ->withDetails($data)
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                )
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
                ->build();

            $_SESSION['stepData'][] = $reportHandler->getRequestData("OrderPosting", $testData);

            $apiResponse = $orderPosting->initiateRequest();


            $_SESSION['stepData'][] = $reportHandler->getResponseData("Order Posting", json_decode($apiResponse, true));

            $orderpostingResponse = new OrderPostingResponse($apiResponse);
            $testCaseHandler->assertEquals("Verification for Status code [OrderPostingAPI]",
                $orderpostingResponse->gethttp_status(),
                $testData["StatusCode"]);
            $testCaseHandler->assertEquals("Verification for Status Description [OrderPostingAPI]",
                $orderpostingResponse->getResponse_description(),
                $testData["StatusDescription"]);
            $testCaseHandler->assertNotNull("Verification for OVV [OrderPostingAPI]", $orderpostingResponse->getOvv());
            $testCaseHandler->assertNotNull("Verification for CallId [OrderPostingAPI]",
                $orderpostingResponse->getCallId());
            $testCaseHandler->assertNotNull("Verification for CreationTimeStamp [OrderPostingAPI]",
                $orderpostingResponse->getCreationTimeStamp());
            $testCaseHandler->assertEquals("Verification for Status [OrderPostingAPI]",
                $orderpostingResponse->getStatus(),
                $testData["Status"]);
            $testCaseHandler->assertEquals("Verification for Intent [OrderPostingAPI]",
                $orderpostingResponse->getIntent(),
                $testData["Intent"]);

            return $orderpostingResponse;
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in OrderPostingAPI",
                $exception->getMessage());
        }
    }
}
