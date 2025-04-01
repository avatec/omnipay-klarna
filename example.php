<?php
require 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('\\Omnipay\\Klarna\\Gateway');
$gateway->initialize([
    'merchantId' => 'YOUR_MERCHANT_ID',
    'sharedSecret' => 'YOUR_SHARED_SECRET',
    'testMode' => true,
    'region' => 'EU'
]);

$response = $gateway->purchase([
    'amount' => '100.00',
    'currency' => 'EUR',
    'returnUrl' => 'https://your-site.com/return',
    'notifyUrl' => 'https://your-site.com/notify',
    'transactionId' => uniqid(),
    'items' => [
        [
            'name' => 'Product 1',
            'price' => '50.00',
            'quantity' => 2,
            'taxRate' => 25
        ]
    ],
    'country' => 'SE'
])->send();

if ($response->isRedirect()) {
    $response->redirect();
} else {
    echo $response->getMessage();
}