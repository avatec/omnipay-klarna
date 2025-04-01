<?php

namespace Omnipay\Klarna\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount', 'currency', 'returnUrl', 'notifyUrl');

        $data = $this->createOrderObject();
        $data['merchant_reference1'] = $this->getTransactionId();

        return $data;
    }

    public function sendData($data): PurchaseResponse
    {
        $headers = $this->getAuthHeaders();

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint() . '/checkout/v3/orders',
            $headers,
            json_encode($data)
        );

        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }
}