<?php

namespace App\Libraries;

use Razorpay\Api\Api;

class RazorpayLibrary
{
    protected $api;
    protected $logger;

    public function __construct()
    {
        $this->api = new Api(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));
        $this->logger = service('logger');
    }

    public function createOrder($options)
    {
        try {
            $order = $this->api->order->create($options);
            $this->logger->debug('Razorpay Order Created: ' . json_encode($order));
            return $order;
        } catch (\Exception $e) {
            $this->logger->error('Razorpay Order Creation Failed: ' . $e->getMessage());
            throw new \Exception('Error creating Razorpay order');
        }
    }
}
