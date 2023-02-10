<?php

namespace App\Exception;

class BuildException extends \Exception
{
    public function errorMessage()
    {
        return 'BuildException: ' . $this->getMessage();
    }
}
