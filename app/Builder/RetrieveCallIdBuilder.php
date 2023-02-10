<?php
//define GetPaymentPlanBuilder class
namespace App\Builder;

use App\Builder\BaseBuilder;
use App\Request\RetrieveCallIdRequest;
use App\Validator\RetrieveCallIdValidator;

class RetrieveCallIdBuilder extends BaseBuilder
{
    private string $callId;

    public function build()
    {
        if (RetrieveCallIdValidator::validate($this)) {
            return new RetrieveCallIdRequest($this);
        }
    }

    public function withCallId(string $callId): RetrieveCallIdBuilder
    {
        $this->callId = $callId;
        return $this;
    }

    public function getCallId(): string
    {
        return $this->callId;
    }
}
