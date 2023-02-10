<?php

namespace App\Exception;

class RequestException extends \Exception
{

    public function errorMessage()
    {
        if ($this->getMessage() == 400) {
            $successDescription = 'Bad Request – One of the request attributes didn’t match the Schema rules';
        } elseif ($this->getMessage() == 401) {
            $successDescription = 'Unauthorized';
        } elseif ($this->getMessage() == 404) {
            $successDescription = 'Merchant not found';
        } elseif ($this->getMessage() == 403) {
            $successDescription = 'Invalid API gateway key';
        } elseif ($this->getMessage() == 500) {
            $successDescription = 'Server error';
        } else {
            $successDescription = 'Undefined Error';
        }
        return 'RequestException: ' . $this->getMessage() . "  " . $successDescription;
    }
}
