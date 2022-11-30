<?php

namespace Tests\Feature\Ch3_3\PaymentClients;

class EcPayClient implements PaymentClient
{
    /**
     * @param string[] $config
     */
    public function __construct(array $config)
    {
    }

    public function pay($order)
    {
        return [
            'orderNo' => 'orderNo_123',
            'platform' => 'EcPay',
        ];
    }

    public function decrypt($order)
    {
        return [
            'orderNo' => 'orderNo_123',
            'platform' => 'EcPay',
        ];
    }
}
