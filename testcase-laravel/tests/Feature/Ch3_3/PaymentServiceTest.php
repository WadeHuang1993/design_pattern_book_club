<?php

namespace Tests\Feature\Ch3_3;

use Tests\TestCase;

class PaymentServiceTest extends TestCase
{

    public function testPay()
    {
        $this->specify(
            '
             使用超商付款的訂單，
             開始第三方金流建立交易流程，
             系統透過 EcPay 金流平台建立訂單成功，
            ',
            function () {
                /** @given 使用超商付款的訂單 */
                $order = [];
                $paymentMethod = 'CVS';

                /** @when 開始第三方金流建立交易流程 */
                $result = PaymentService::pay($order, $paymentMethod);

                /** @then 系統透過 EcPay 金流平台建立訂單成功 */
                self::assertEquals('EcPay', $result['platform']);
            }
        );

        $this->specify(
            '
             使用 信用卡 付款的訂單，
             開始第三方金流建立交易流程，
             系統透過 EcPay 金流平台建立訂單成功，
            ',
            function () {
                /** @given 使用 信用卡 付款的訂單， */
                $order = [];
                $paymentMethod = 'CreditCard';

                /** @when 開始第三方金流建立交易流程 */
                $result = PaymentService::pay($order, $paymentMethod);

                /** @then 系統透過 EcPay 金流平台建立訂單成功 */
                self::assertEquals('EcPay', $result['platform']);
            }
        );
    }

    public function testPaidSuccessWebhook()
    {
        $this->specify(
            '
            第三方付款泡送過來的 超商付款 訂單已付款通知，
            系統解密參數並且變更訂單狀態為：已付款，
            系統將 EcPay 金流平台的訂單變更為已付款，
            ',
            function () {
                /** @given 第三方付款泡送過來的 超商付款 訂單已付款通知 */
                $orderParams = [];
                $paymentMethod = 'CVS';

                /** @when 系統解密參數並且變更訂單狀態為：已付款 */
                $result = PaymentService::paidSuccessWebhook($orderParams, $paymentMethod);

                /** @then 系統將 EcPay 金流平台的訂單變更為已付款 */
                self::assertEquals('EcPay', $result['platform']);
            }
        );
        $this->specify(
            '
            第三方付款泡送過來的 信用卡付款 訂單已付款通知，
            系統解密參數並且變更訂單狀態為：已付款，
            系統將 EcPay 金流平台的訂單變更為已付款，
            ',
            function () {
                /** @given 第三方付款泡送過來的 信用卡付款 訂單已付款通知 */
                $orderParams = [];
                $paymentMethod = 'CreditCard';

                /** @when 系統解密參數並且變更訂單狀態為：已付款 */
                $result = PaymentService::paidSuccessWebhook($orderParams, $paymentMethod);

                /** @then 系統將 NewebPay 金流平台的訂單變更為已付款 */
                self::assertEquals('EcPay', $result['platform']);
            }
        );
    }
}
