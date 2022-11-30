<?php

namespace Tests\Feature\Ch3_3\PaymentClientFactories;

use Tests\Feature\Ch3_3\PaymentClients\PaymentClient;

interface PaymentClientFactory
{
    /**
     * 初始化 指定付款方式 的第三方金流 Client
     *
     * @return PaymentClient
     */
    public function create(): PaymentClient;
}
