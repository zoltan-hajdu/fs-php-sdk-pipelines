<?php
//define Redirect url Builer class
namespace App\Builder\Support;

class RedirectUrlsBuilder
{
    private ?string $failureUrl = null;
    private string $cancelUrl;
    private string $successUrl;

    public function withFailureUrl(?string $failureUrl = null): RedirectUrlsBuilder
    {
        $this->failureUrl = $failureUrl;
        return $this;
    }

    public function withCancelUrl(string $cancelUrl): RedirectUrlsBuilder
    {
        $this->cancelUrl = $cancelUrl;
        return $this;
    }

    public function withSuccessUrl(string $successUrl): RedirectUrlsBuilder
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    public function getFailureUrl()
    {
        if (isset($this->failureUrl)) {
            return $this->failureUrl;
        }
    }

    public function getCancelUrl(): string
    {
        return $this->cancelUrl;
    }

    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }
}
