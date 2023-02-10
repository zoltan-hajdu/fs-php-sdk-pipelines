<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class FrameworkUtils
{
    public static function getTransactionID()
    {
        return sprintf("%010s%s", date("Ymdhis"), mt_rand(1000, 9999));
    }
}
