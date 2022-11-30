<?php

namespace Tests\Feature\Ch3_3\PaymentClientFactories;

use Illuminate\Support\Facades\Log;
use Tests\Feature\Ch3_3\PaymentClients\PaymentClient;

abstract class PaymentClientFactory
{
    /**
     * 初始化 PaymentClient 並且押上系統記錄
     *
     * @return PaymentClient
     */
    public function initClient(): PaymentClient
    {
        $client = $this->create();

        // 發送 Slack 通知 Or 寫入 Log
        Log::info("訂單有新的異動, ...省略");

        return $client;
    }

    /**
     * 初始化 指定付款方式 的第三方金流 Client
     *
     * @return PaymentClient
     */
    protected abstract function create(): PaymentClient;
}
