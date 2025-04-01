<?php

namespace Omnipay\Klarna;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Klarna';
    }

    public function getDefaultParameters(): array
    {
        return [
            'merchantId' => '',
            'sharedSecret' => '',
            'testMode' => false,
            'region' => 'EU', // EU, NA, etc.
            'apiVersion' => 'v1'
        ];
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getSharedSecret()
    {
        return $this->getParameter('sharedSecret');
    }

    public function setSharedSecret($value)
    {
        return $this->setParameter('sharedSecret', $value);
    }

    public function getRegion()
    {
        return $this->getParameter('region');
    }

    public function setRegion($value)
    {
        return $this->setParameter('region', $value);
    }

    public function authorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Klarna\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Klarna\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Klarna\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Klarna\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Klarna\Message\RefundRequest', $parameters);
    }
}