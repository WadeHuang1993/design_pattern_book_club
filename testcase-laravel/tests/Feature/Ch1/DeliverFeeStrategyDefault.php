<?php

namespace Tests\Feature\Ch1;

/**
 * 計算是否免運的策略
 *
 * 這是系統最預設的免運判斷邏輯，只要滿千就免運
 */
class DeliverFeeStrategyDefault implements DeliverFeeStrategy
{

    public function __construct()
    {
    }

    /**
     * 是否符合免運條件
     * @param ShoppingCart $cart
     * @return bool
     */
    public function isFree(ShoppingCart $cart)
    {
        return $cart->products->sum('price') >= 1000;
    }
}
