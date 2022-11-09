<?php

namespace Tests\Feature\Ch1;

class DeliverFeeStrategyFactory
{
    /**
     * 建立運費演算法
     *
     * @param ShoppingCart $cart
     * @return DeliverFeeStrategy
     */
    public static function create(ShoppingCart $cart)
    {
        // 有符合 2022 聖誕節活動嗎？
        if (self::christmasEvent2022($cart)) {
            return new DeliverFeeStrategyChristmasGift2022();
        }

        return new DeliverFeeStrategyDefault();
    }

    /**
     * 有符合 2022 聖誕節活動嗎？
     *
     * @param ShoppingCart $cart
     * @return bool
     */
    public static function christmasEvent2022(ShoppingCart $cart)
    {
        return $cart->currentDate === '2022/12/24';
    }
}
