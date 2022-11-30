<?php

namespace Tests\Feature\Ch3_3\PaymentClients;

interface PaymentClient
{

    /**
     * 向第三方金流平台建立一筆交易
     *
     * @param $order
     * @return array
     */
    public function pay($order);

    /**
     * 解析第三方金流平台泡送過來的參數
     *
     * @param $order
     * @return array
     */
    public function decrypt($order);
}
