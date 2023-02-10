<?php

namespace App\Response;

use App\Exception\ResponseException;

abstract class BaseResponse
{
    protected function validate($key, $data)
    {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        } else {
            throw new ResponseException("ResponseException: The " . $key . " doesn't exist in the response.");
        }
    }
}
