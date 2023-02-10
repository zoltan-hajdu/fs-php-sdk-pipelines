<?php
/* declare(strict_types = 1); */

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../utils/FrameworkUtils.php');
require_once(__DIR__ . '/../utils/ReadExcel.php');
require_once(__DIR__ . '/../utils/ReportHandler.php');
require_once(__DIR__ . '/../utils/TestCaseHandler.php');
require_once(__DIR__ . '/SaleAPI.php');

use App\Request\AuthorizationRequest;
use App\Builder\AuthorizationBuilder;
use App\Builder\Support\MerchantDataBuilder;
use App\Builder\Support\TransactionBuilder;
use App\Builder\Support\DetailsBuilder;
use App\Response\AuthorizationResponse;
use App\Response\OrderPostingResponse;
use App\Configuration\Configuration;
use PHPUnit\Framework\TestCase;
use App\Builder\Support\CustomerId;

class AuthorizationAPI
{
    public static function forMSale(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $slaeNTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = empty($testData["OVV"]) ? $orderpostingResponse->getOvv() :
                        $testData["OVV"])
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For MSale",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForMSale]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForMSale]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForMSale]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMSale]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForMSale]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForMSale]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForMSale]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForMSale]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForMSale]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMSale]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForMSale]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForMSale]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeNTestData, $index);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForMSale",
                $exception->getMessage());
        }
    }

    public static function build(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $CustomerId = new CustomerId();
            $merchantData = new MerchantDataBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r("Count***********************" . $transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $transaction = new TransactionBuilder();
                $details = new DetailsBuilder();
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = empty($testData["OVV"]) ? $orderpostingResponse->getOvv() :
                        $testData["OVV"])
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->withlookupType($testData["LookupType"])
                    ->withCustomerId(
                        $CustomerId->withidType($testData["IDType"])
                            ->withidNumber($testData["IDNumber"])
                            ->withprovinceOfIssue($testData["ProvinceOfIssue"])
                            ->withexpiryDate($testData["ExpiryDate"])
                            ->withaddressDifferentFromAccount($testData["AddressDifferentFromAccount"])
                    )
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization Build",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIBuild]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIBuild]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIBuild]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIBuild]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIBuild]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIBuild]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIBuild]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIBuild]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIBuild]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIBuild]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIBuild]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIBuild]",
                    $autorizationResponse->getValidUntil());

                if ($slaeTestData) {
                    $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);
                    //return $saleResponse ;
                }
                return $autorizationResponse;
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIBuild",
                $exception->getMessage());
        }
    }

    public static function multiple(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData)
    {
        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId(FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate(Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();
                $apiResponse = $authorizationRequest->initiateRequest();

                $autorizationResponse = new AuthorizationResponse($apiResponse);
                TestCase::assertEquals($autorizationResponse->gethttp_status(),
                    $testData["StatusCode"],
                    "Verification for Status code. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"],
                    "Verification for Status Description. Method: multiple");
                TestCase::assertNotNull($autorizationResponse->getTransactionId(),
                    "Verification for TransactionId. Method: multiple");
                TestCase::assertNotNull($autorizationResponse->getOvv(), "Verification for OVV. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"],
                    "Verification for ResponseCode. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getStatus(),
                    $testData["Status"],
                    "Verification for Status. Method: multiple");
                TestCase::assertNotNull($autorizationResponse->getAuthorizationCode(),
                    "Verification for AuthorizationCode. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index],
                    "Verification for TransactionAmount. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"],
                    "Verification for AccountNumber. Method: multiple");
                TestCase::assertNotNull($autorizationResponse->getDateProcessed(),
                    "Verification for Date Processed. Method: multiple");
                TestCase::assertEquals($autorizationResponse->getIntent(),
                    $testData["RIntent"],
                    "Verification for Intent. Method: multiple");
                TestCase::assertNotNull($autorizationResponse->getValidUntil(),
                    "Verification for ValidUntil. Method: multiple");
                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);
                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Exception Message at AuthorizationAPI. Method: multiple");
        }
    }

    public static function forVoidAuthorization(OrderPostingResponse $orderpostingResponse, $testData, $voidTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $CustomerId = new CustomerId();
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->withlookupType($testData["LookupType"])
                    ->withCustomerId(
                        $CustomerId->withidType($testData["IDType"])
                            ->withidNumber($testData["IDNumber"])
                            ->withprovinceOfIssue($testData["ProvinceOfIssue"])
                            ->withexpiryDate($testData["ExpiryDate"])
                            ->withaddressDifferentFromAccount($testData["AddressDifferentFromAccount"])
                    )
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Void Authorization",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForVoidAuthorization]",
                    $autorizationResponse->getValidUntil());

                VoidAuthorizationtestAPI::build($autorizationResponse, $voidTestData);
                return $autorizationResponse;
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForVoidAuthorization",
                $exception->getMessage());
        }
    }

    public static function forMVoidAuthorization(OrderPostingResponse $orderpostingResponse, $testData, $voidTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For MVoid Authorization",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForMVoidAuthorization]",
                    $autorizationResponse->getValidUntil());

                VoidAuthorizationtestAPI::build($autorizationResponse, $voidTestData);

                VoidAuthorizationtestAPI::build($autorizationResponse, $voidTestData);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForMVoidAuthorization",
                $exception->getMessage());
        }
    }


    public static function forReturn(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $CustomerId = new CustomerId();
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->withlookupType($testData["LookupType"])
                    ->withCustomerId(
                        $CustomerId->withidType($testData["IDType"])
                            ->withidNumber($testData["IDNumber"])
                            ->withprovinceOfIssue($testData["ProvinceOfIssue"])
                            ->withexpiryDate($testData["ExpiryDate"])
                            ->withaddressDifferentFromAccount($testData["AddressDifferentFromAccount"])
                    )
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Return",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForReturn]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForReturn]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForReturn]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReturn]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForReturn]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForReturn]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForReturn]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForReturn]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForReturn]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReturn]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForReturn]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForReturn]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                $returnResponse = ReturnAPI::build($saleResponse, $autorizationResponse, $returnTestData, $index);

                return $returnResponse;
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForReturn",
                $exception->getMessage());
        }
    }

    public static function forMReturn(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For MReturn",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);
                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForMReturn]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForMReturn]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                ReturnAPI::build($saleResponse, $autorizationResponse, $returnTestData, $index);

                ReturnAPI::build($saleResponse, $autorizationResponse, $returnTestData, $index);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForMReturn",
                $exception->getMessage());
        }
    }

    public static function forVoid(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData, $voidTestData)
    {
        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId(FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate(Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();
                $apiResponse = $authorizationRequest->initiateRequest();

                $autorizationResponse = new AuthorizationResponse($apiResponse);
                TestCase::assertEquals($autorizationResponse->gethttp_status(),
                    $testData["StatusCode"],
                    "Verification for Status code. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"],
                    "Verification for Status Description. Method: forVoid");
                TestCase::assertNotNull($autorizationResponse->getTransactionId(),
                    "Verification for TransactionId. Method: forVoid");
                TestCase::assertNotNull($autorizationResponse->getOvv(), "Verification for OVV. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"],
                    "Verification for ResponseCode. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getStatus(),
                    $testData["Status"],
                    "Verification for Status. Method: forVoid");
                TestCase::assertNotNull($autorizationResponse->getAuthorizationCode(),
                    "Verification for AuthorizationCode. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index],
                    "Verification for TransactionAmount. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"],
                    "Verification for AccountNumber. Method: forVoid");
                TestCase::assertNotNull($autorizationResponse->getDateProcessed(),
                    "Verification for Date Processed. Method: forVoid");
                TestCase::assertEquals($autorizationResponse->getIntent(),
                    $testData["RIntent"],
                    "Verification for Intent. Method: forVoid");
                TestCase::assertNotNull($autorizationResponse->getValidUntil(),
                    "Verification for ValidUntil. Method: forVoid");
                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);
                $returnResponse = ReturnAPI::build($saleResponse, $autorizationResponse, $returnTestData, $index);
                VoidAPI::return($returnResponse, $autorizationResponse->getAuthorizationCode(), $voidTestData);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Exception Message at AuthorizationAPI. Method: forVoid");
        }
    }

    public static function forViod(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $voidTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Viod",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForViod]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForViod]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForViod]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForViod]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForViod]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForViod]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForViod]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForViod]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForViod]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForViod]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForViod]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForViod]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                VoidAPI::perform($saleResponse, $autorizationResponse, $voidTestData, $index);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForViod",
                $exception->getMessage());
        }
    }


    public static function forReversal(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $reversalTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Reversal",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForReversal]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForReversal]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForReversal]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReversal]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForReversal]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForReversal]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForReversal]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForReversal]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForReversal]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReversal]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForReversal]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForReversal]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                ReversalAPI::forSale($autorizationResponse, $saleResponse, $reversalTestData, $index);
            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForReversal",
                $exception->getMessage());
        }
    }

    public static function forVoidReturn(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData, $voidTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Void Return",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForVoidReturn]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                VoidAPI::perform($saleResponse, $autorizationResponse, $voidTestData, $index);

                $returnResponse = ReturnAPI::withSale($saleResponse, $autorizationResponse, $returnTestData, $index);

            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForVoidReturn",
                $exception->getMessage());
        }
    }


    public static function forReturnVoid(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData, $voidTestData)
    {
        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId(FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate(Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();
                $apiResponse = $authorizationRequest->initiateRequest();

                $autorizationResponse = new AuthorizationResponse($apiResponse);
                TestCase::assertEquals($autorizationResponse->gethttp_status(),
                    $testData["StatusCode"],
                    "Verification for Status code. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"],
                    "Verification for Status Description. Method: forReturnVoid");
                TestCase::assertNotNull($autorizationResponse->getTransactionId(),
                    "Verification for TransactionId. Method: forReturnVoid");
                TestCase::assertNotNull($autorizationResponse->getOvv(), "Verification for OVV. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"],
                    "Verification for ResponseCode. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getStatus(),
                    $testData["Status"],
                    "Verification for Status. Method: forReturnVoid");
                TestCase::assertNotNull($autorizationResponse->getAuthorizationCode(),
                    "Verification for AuthorizationCode. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index],
                    "Verification for TransactionAmount. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"],
                    "Verification for AccountNumber. Method: forReturnVoid");
                TestCase::assertNotNull($autorizationResponse->getDateProcessed(),
                    "Verification for Date Processed. Method: forReturnVoid");
                TestCase::assertEquals($autorizationResponse->getIntent(),
                    $testData["RIntent"],
                    "Verification for Intent. Method: forReturnVoid");
                TestCase::assertNotNull($autorizationResponse->getValidUntil(),
                    "Verification for ValidUntil. Method: forReturnVoid");
                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);
                ReturnAPI::withSale($saleResponse, $autorizationResponse, $returnTestData, $index);
                VoidAPI::perform($saleResponse, $autorizationResponse, $voidTestData, $index);

            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            TestCase::assertNull($exception, "Exception Message at AuthorizationAPI. Method: forReturnVoid");
        }
    }

    public static function forReturnVoidVoid(OrderPostingResponse $orderpostingResponse, $testData, $slaeTestData, $returnTestData, $voidTestData)
    {
        $reportHandler = new ReportHandler();
        $testCaseHandler = new TestCaseHandler();

        try {
            $merchantData = new MerchantDataBuilder();
            $transaction = new TransactionBuilder();
            $details = new DetailsBuilder();
            $transCount = count(explode(",", $testData["CreditPlan"]));
            print_r($transCount);
            for ($index = 0; $index < $transCount; $index++) {
                $authorizationRequest = AuthorizationRequest::newBuilder()
                    ->withTransactionId($testData["TransactionId"] = FrameworkUtils::getTransactionID())
                    ->withIntent($testData["Intent"])
                    ->withOvv($testData["OVV"] = $orderpostingResponse->getOvv())
                    ->withAccountNumber($testData["AccountNumber"])
                    ->withMerchantData(
                        $merchantData->withPaymentGatewayId($testData["PaymentGatewayId"])
                            ->withMerchantNumber($testData["MerchantNumber"])
                            ->withStoreNumber($testData["StoreNumber"])
                            ->withSource($testData["Source"])
                    )
                    ->withLastFourDigits($testData["LastFourDigits"])
                    ->withTransaction($transaction->withCreditPlan(explode(",", $testData["CreditPlan"])[$index])
                        ->withDetails(
                            $details->withItemNumber(explode(",", $testData["ItemNumber"])[$index])
                                ->withSubTotal(explode(",", $testData["SubTotal"])[$index])
                        )
                        ->withInvoiceNumber($testData["InvoiceNumber"])
                        ->withTotal($testData["Total"])
                        ->withTransactionAmount(explode(",", $testData["TransactionAmount"])[$index])
                        ->withTransactionDate($testData["TransactionDate"] = Configuration::getDate()))
                    ->withDescription($testData["RDescription"])
                    ->build();

                $_SESSION['stepData'][] = $reportHandler->getRequestData("Authorization", $testData);

                $apiResponse = $authorizationRequest->initiateRequest();


                $_SESSION['stepData'][] = $reportHandler->getResponseData("Authorization For Return Void Void",
                    json_decode($apiResponse, true));

                $autorizationResponse = new AuthorizationResponse($apiResponse);

                $testCaseHandler->assertEquals("Verification for Status code [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->gethttp_status(),
                    $testData["StatusCode"]);
                $testCaseHandler->assertEquals("Verification for Status Description [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getResponse_description(),
                    $testData["StatusDescription"]);
                $testCaseHandler->assertNotNull("Verification for TransactionId [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getTransactionId());
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getOvv());
                $testCaseHandler->assertEquals("Verification for ResponseCode [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getResponseCode(),
                    $testData["ResponseCode"]);
                $testCaseHandler->assertEquals("Verification for Status [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getStatus(),
                    $testData["Status"]);
                $testCaseHandler->assertNotNull("Verification for AuthorizationCode [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getAuthorizationCode());
                $testCaseHandler->assertEquals("Verification for TransactionAmount [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getTransactionAmount(),
                    explode(",", $testData["RTransactionAmount"])[$index]);
                $testCaseHandler->assertEquals("Verification for AccountNumber [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getAccountNumber(),
                    $testData["RAccountNumber"]);
                $testCaseHandler->assertNotNull("Verification for OVV [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getDateProcessed());
                $testCaseHandler->assertEquals("Verification for Intent [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getIntent(),
                    $testData["Intent"]);
                $testCaseHandler->assertNotNull("Verification for ValidUntil [AuthorizationAPIForReturnVoidVoid]",
                    $autorizationResponse->getValidUntil());

                $saleResponse = SaleAPI::perform($autorizationResponse, $slaeTestData, $index);

                $returnResponse = ReturnAPI::withSale($saleResponse, $autorizationResponse, $returnTestData, $index);

                VoidAPI::return($returnResponse, $autorizationResponse->getAuthorizationCode(), $voidTestData);

                VoidAPI::return($returnResponse, $autorizationResponse->getAuthorizationCode(), $voidTestData);

            }
        } catch (Exception $exception) {
            print $exception->getMessage();
            $_SESSION['stepData'][] = $reportHandler->getErrorData("Exception in AuthorizationAPIForReturnVoidVoid",
                $exception->getMessage());
        }
    }


}
