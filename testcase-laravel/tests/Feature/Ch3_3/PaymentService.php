<?php

namespace Tests\Feature\Ch3_3;

use Tests\Feature\Ch3_3\PaymentClientFactories\ConvenienceStorePaymentClientFactory;
use Tests\Feature\Ch3_3\PaymentClients\EcPayClient;
use Tests\Feature\Ch3_3\PaymentClients\LinePayClient;
use Tests\Feature\Ch3_3\PaymentClients\NewebPayClient;

class PaymentService
{
    /**
     * 向第三方金流平台發送 API 建立一筆交易
     *
     * @param array $order 訂單內容
     * @param string $paymentMethod 付款方式
     * @return array
     */
    public static function pay($order, $paymentMethod)
    {
        // 因應付款方式建立第三方金流 Client
        if ($paymentMethod === 'CVS') {
            $paymentClient = ConvenienceStorePaymentClientFactory::create();
        }
        if ($paymentMethod === 'CreditCard') {
            $config = [
                'hashIv' => 'hashIv-EcPay-123',
                'hashVI' => 'hashVI-EcPay-123',
            ];

            $paymentClient = new EcPayClient($config);
        }
        if ($paymentMethod === 'LinePay') {
            $config = [
                'channel' => 'channel-123',
                'secret' => 'secret-123',
            ];

            $paymentClient = new LinePayClient($config);
        }

        // 向第三方金流平台建立一筆交易
        $result = $paymentClient->pay($order);
        return $result;
    }

    /**
     * 檢查訂單狀態
     *
     * @return array
     */
    public static function paidSuccessWebhook($orderParams, $paymentMethod)
    {
        // 因應付款方式建立第三方金流 Client
        if ($paymentMethod === 'CVS') {
            $paymentClient = ConvenienceStorePaymentClientFactory::create();
        }
        if ($paymentMethod === 'CreditCard') {
            $config = [
                'hashIv' => 'hashIv-EcPay-123',
                'hashVI' => 'hashVI-EcPay-123',
            ];

            $paymentClient = new EcPayClient($config);
        }
        if ($paymentMethod === 'LinePay') {
            $config = [
                'channel' => 'channel-123',
                'secret' => 'secret-123',
            ];

            $paymentClient = new LinePayClient($config);
        }

        // 向第三方金流平台建立一筆交易
        $order = $paymentClient->decrypt($orderParams);

        // 將訂單變更為已付款
//        $result = OrderRepository::updatePaid($order);

        return $order;
    }
}
