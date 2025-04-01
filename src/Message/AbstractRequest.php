<?php

namespace Omnipay\Klarna\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected string $liveEndpoint = 'https://api.klarna.com';
    protected string $testEndpoint = 'https://api.playground.klarna.com';

    public function getEndpoint(): string
    {
        $base = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
        return $base . '/' . $this->getApiVersion();
    }

    public function getApiVersion()
    {
        return $this->getParameter('apiVersion') ?: 'v1';
    }

    public function setApiVersion($value)
    {
        return $this->setParameter('apiVersion', $value);
    }

    public function getRegion()
    {
        return $this->getParameter('region');
    }

    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->getMerchantId() . ':' . $this->getSharedSecret()),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    protected function createOrderObject(): array
    {
        $items = [];
        foreach ($this->getItems() as $item) {
            $items[] = [
                'reference' => $item->getName(),
                'name' => $item->getName(),
                'quantity' => $item->getQuantity(),
                'unit_price' => $this->formatCurrency($item->getPrice()),
                'tax_rate' => $item->getTaxRate() ?? 0,
                'total_amount' => $this->formatCurrency($item->getPrice() * $item->getQuantity()),
                'total_tax_amount' => $this->formatCurrency(($item->getPrice() * $item->getQuantity() * $item->getTaxRate()) / 100)
            ];
        }

        return [
            'purchase_country' => $this->getCountry(),
            'purchase_currency' => $this->getCurrency(),
            'locale' => $this->getLocale(),
            'order_amount' => $this->getAmountInteger(),
            'order_tax_amount' => $this->calculateTotalTax(),
            'order_lines' => $items,
            'merchant_urls' => [
                'terms' => $this->getParameter('termsUrl'),
                'checkout' => $this->getParameter('returnUrl'),
                'confirmation' => $this->getParameter('returnUrl'),
                'push' => $this->getParameter('notifyUrl')
            ]
        ];
    }

    public function formatCurrency($amount): int
    {
        return (int) round($amount * 100);
    }

    protected function calculateTotalTax(): int
    {
        $totalTax = 0;
        foreach ($this->getItems() as $item) {
            $totalTax += ($item->getPrice() * $item->getQuantity() * $item->getTaxRate()) / 100;
        }
        return $this->formatCurrency($totalTax);
    }
}