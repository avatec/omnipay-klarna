<?php

namespace Omnipay\Klarna\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return isset($this->data['order_id']);
    }

    public function isRedirect(): bool
    {
        return isset($this->data['redirect_url']);
    }

    public function getRedirectUrl()
    {
        return $this->data['redirect_url'] ?? null;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionReference()
    {
        return $this->data['order_id'] ?? null;
    }

    public function getMessage()
    {
        return $this->data['error_message'] ?? null;
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function redirect()
    {
        // TODO: Implement redirect() method.
    }

    public function getRequest()
    {
        // TODO: Implement getRequest() method.
    }

    public function isCancelled()
    {
        // TODO: Implement isCancelled() method.
    }

    public function getCode()
    {
        // TODO: Implement getCode() method.
    }
}