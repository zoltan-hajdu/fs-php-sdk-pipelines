<?php
//define BaseRequest class
namespace App\Request;

abstract class BaseRequest
{

    abstract public function initiateRequest();

    abstract public static function newBuilder();
}
