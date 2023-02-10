<?php
//define Validation Helper class
namespace App\Helper;

require_once('vendor/autoload.php');

use Respect\Validation\Validator as v;
use App\Exception\BuildException;

class ValidationHelper
{
    const CONTENT_TYPE = 'Content-type: text/plain';

    public function transactionId($transactionId)
    {
        try {
            $trasactionnew = v::stringType()->length(1, 30)->validate($transactionId);
            $message = "Transaction Id";
            if (!$trasactionnew) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function accountNumber($accountNumber)
    {
        try {
            $newaccountNumber = v::stringType()->length(19, 19)->validate($accountNumber);
            $message = "Account Number";
            if (!$newaccountNumber) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }

    public function merchantNumber($merchantNumber)
    {
        try {
            $newmerchantNumber = v::stringType()->length(1, 9)->validate($merchantNumber);
            $message = "Merchant Number";
            if (!$newmerchantNumber) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function StoreNumber($StoreNumber)
    {
        try {
            $newStoreNumber = v::stringType()->length(9, 9)->validate($StoreNumber);
            $message = "Store Number";
            if (!$newStoreNumber) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function CreditPlan($CreditPlan)
    {
        try {
            $newcreditplan = v::stringType()->length(1, 9)->validate($CreditPlan);
            $message = "Credit Plan";
            if (!$newcreditplan) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function TransactionType($Transation_Type)
    {
        try {
            $newTransation_Type = v::stringType()->length(4, 6)->validate($Transation_Type);
            $message = "Transaction Type";
            if (!$newTransation_Type) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function TransactionAmount($Transation_Amount)
    {
        try {
            $newTransation_Amount = v::numericVal()->min(0)->validate($Transation_Amount);
            $message = "Transaction Amount";
            if (!$newTransation_Amount) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }

    public function invoiceNumber($invoiceNumber)
    {
        try {
            $newinvoiceNumber = v::stringType()->length(1, 15)->validate($invoiceNumber);
            $message = "Invoice Number";
            if (!$newinvoiceNumber) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }

    public function authorizationCode($authorizationCode)
    {
        try {
            $newauthorizationCode = v::stringType()->length(6, 6)->validate($authorizationCode);
            $message = "Authorization code";
            if (!$newauthorizationCode) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function SalePerson($salePerson)
    {
        try {
            $newsalePerson = v::stringType()->length(1, 12)->validate($salePerson);
            $message = "Sales Person";
            if (!$newsalePerson) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }

    public function cancelType($cancelType)
    {
        try {
            $newcancelType = v::stringType()->length(4, 6)->validate($cancelType);
            $message = "Cancel Type";
            if (!$newcancelType) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function customerId($customerId)
    {
        try {
            $newcustomerId = v::stringType()->length(25, 25)->validate($customerId);
            $message = "Customer ID";
            if (!$newcustomerId) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function callId($callId)
    {
        try {
            $newcallId = v::stringType()->length(40, 45)->validate($callId);
            $message = "Customer ID";
            if (!$newcallId) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }


    public function orderMethod($orderMethod)
    {
        try {
            $neworderMethod = v::stringType()->length(2, 6)->validate($orderMethod);
            $message = "Order Method";
            if (!$neworderMethod) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }

    public function ovv($ovv)
    {
        try {
            $newovv = v::alpha()->validate($ovv);
            $message = "OVV";
            if (!$newovv) {
                throw new BuildException($message);
            }
            return $this;
        } catch (BuildException $e) {
            header(self::CONTENT_TYPE);
            echo $e->errorMessage();
        }
    }
}
