<?php

namespace Tests\Feature\Ch3_3\PaymentClientFactories;

use Tests\Feature\Ch3_3\PaymentClients\EcPayClient;
use Tests\Feature\Ch3_3\PaymentClients\PaymentClient;

class ConvenienceStorePaymentClientFactory extends PaymentClientFactory
{
    /**
     * 初始化超商付款的第三方金流 Client
     *
     * @return PaymentClient
     */
    public function create(): PaymentClient
    {
        $config = [
            'hashIv' => 'hashIv-NewebPay-123',
            'hashVI' => 'hashVI-NewebPay-123',
        ];

        return new EcPayClient($config);
    }
}
