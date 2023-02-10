<?php
//define configuration  class
namespace App\Configuration;

use Dotenv\Dotenv;

class Configuration
{
    public static function getApiDomain(): string
    {
        return self::getEnv('DOMAIN');
    }

    public static function getRetailApiDomain(): string
    {
        return self::getEnv('RETAIL_DOMAIN');
    }

    public static function getApiSecret(): string
    {
        return self::getEnv('SECRET');
    }

    public static function getApiKey(): string
    {
        return self::getEnv('API_KEY');
    }

    public static function getClientId(): string
    {
        return self::getEnv('CLIENT_ID');
    }

    public static function getSignature(string $string): string
    {
        $secret = trim(self::getEnv('SECRET'));
        $signature = hash_hmac('sha256', $string, $secret);
        return $signature;
    }

    public static function getAuthorization(): string
    {
        return self::getEnv('AUTHORIZATION');
    }

    public static function getPaymentgateway(): string
    {
        return self::getEnv('PAYMENTGATEWAYID');
    }

    public static function getAcceptLanguage(): string
    {
        return self::getEnv('ACCEPT_LANGUAGE');
    }

    public static function getEpoch(): string
    {
        return (string)time();
    }

    public static function getDate(): string
    {
        $t = explode(" ", microtime());
        $date = date('Y-m-d\TH:i:s', $t[1]) . substr((string)$t[0], 1, 4) . 'Z';
        return $date;
    }

    public static function getBaseURL(): string
    {
        return self::getEnv('BASE_URL');
    }

    public static function getRetailBaseURL(): string
    {
        return self::getEnv('RETAIL_BASE_URL');
    }

    public static function getMerchantHash(): string
    {
        return self::getEnv('MERCHANT_HASH');
    }

    public static function isEnableLogging(): bool
    {
        $logging = self::getEnv('ENABLE_LOGGING');
        return ($logging == 1) ? true : false;
    }

    public static function getEnv(string $key): string
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        return $_ENV[$key];
    }
}
