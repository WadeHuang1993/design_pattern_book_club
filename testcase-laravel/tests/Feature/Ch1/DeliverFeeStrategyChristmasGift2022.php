<?php

namespace Tests\Feature\Ch1;

/**
 * 2022 年聖誕活動運費演算法
 */
class DeliverFeeStrategyChristmasGift2022 implements DeliverFeeStrategy
{

    public function __construct()
    {
    }

    /**
     * 若有購買任一個聖誕禮物則免運
     *
     * @param ShoppingCart $cart
     * @return bool|int
     */
    public function isFree(ShoppingCart $cart)
    {
        $hasChristmasGift = $cart->products->whereIn('productCode', ['christmas_gift'])
            ->count();
        if ($hasChristmasGift) {
            return true;
        }

        return (new DeliverFeeStrategyDefault())->isFree($cart);
    }
}
