<?php

namespace Tests\Feature\Ch3_3\PaymentClientFactories;

use Tests\Feature\Ch3_3\PaymentClients\EcPayClient;
use Tests\Feature\Ch3_3\PaymentClients\PaymentClient;

class CreditCardPaymentClientFactory implements PaymentClientFactory
{
    /**
     * 初始化信用卡付款的第三方金流 Client
     *
     * @return PaymentClient
     */
    public function create(): PaymentClient
    {
        $config = [
            'hashIv' => 'hashIv-EcPay-123',
            'hashVI' => 'hashVI-EcPay-123',
        ];
        return new EcPayClient($config);
    }
}
