<?php
//define HttpClient class
namespace App\Helper;

use App\Configuration\Configuration;
use App\Exception\RequestException;

class HttpClient
{

    public static function sendRequest($method, $url, $data, $source = 'POS'): string
    {
        try {
            //Generating the signature
            $strData = html_entity_decode(str_replace("\\", "", json_encode($data, JSON_HEX_QUOT)));
            require('Httpcondition.php');
            $strDate = Configuration::getDate();
            $transEpoch = Configuration::getEpoch();
            if ($method == 'POST') {
                $string = 'POST' . "\n";
                if ($source == 'POS') {
                    $string .= Configuration::getBaseURL() . "\n";
                } else {
                    $string .= Configuration::getRetailBaseURL() . "\n";
                }
                $string .= $strDate . "\n";
                $string .= 'clientId=' . Configuration::getClientId() . '&transEpoch=' . $transEpoch . "\n";
                $string .= $strData;
                $signature = Configuration::getSignature($string);
            }
            //Generating the URL
            $service_url = '';
            if ($source == 'POS') {
                $service_url .= Configuration::getApiDomain() . $url;
            } else {
                $service_url .= Configuration::getRetailApiDomain() . $url;
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CAINFO, __DIR__ . '/../../tests/utils/Shellnium/cacert.pem');
            if ($method == 'POST') {
                $service_url .= '?clientId=' . Configuration::getClientId();
                $service_url .= '&signature=' . $signature;
                $service_url .= '&transEpoch=' . $transEpoch;
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $strData);
            } elseif ($method == 'GET') {
                $service_url .= '?' . http_build_query($data);
            }


            curl_setopt($curl, CURLOPT_URL, $service_url);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'x-api-key:' . trim(Configuration::getApiKey()),
                'Authorization:' . trim(Configuration::getAuthorization()),
                'transDate:' . $strDate,
                'Accept-Language:' . trim(Configuration::getAcceptLanguage()),
                'PaymentGatewayId:' . trim(Configuration::getPaymentgateway()),
                'Content-Type:application/json',
                'Accept:application/json'
            ));
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            $info = curl_getinfo($curl);
            print_r($info);
            curl_close($curl);
            $code = $info['http_code'];
            if ($code == 200) {
                $successDescription = 'Success';
            } else {
                $successDescription = 'Failed';
            }
            $result = json_decode($result, true);
            $result[] = ['response_status' => $code, 'response_description' => $successDescription];
            $result = json_encode($result);
            echo "\n\n" . '=========Request payload======' . "\n\n";

            print_r($strData);

            echo "\n\n" . '=========Response======' . "\n\n";

            print_r($result);

            return $result;
        } catch (RequestException $e) {
            echo $e->errorMessage();
            return '';
        }
    }
}
