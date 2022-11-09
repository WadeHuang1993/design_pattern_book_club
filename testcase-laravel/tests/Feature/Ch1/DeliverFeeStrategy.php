<?php

namespace Tests\Feature\Ch1;


/**
 * 計算是否免運的策略
 *
 */
interface DeliverFeeStrategy
{
    /**
     * 是否符合免運條件
     * @param ShoppingCart $cart
     * @return bool
     */
    public function isFree(ShoppingCart $cart);
}
