<?php

namespace Tests\Feature\Ch1;

class ShoppingCart
{
    public $products;
    // 消費日期
    public $currentDate;

    public function __construct()
    {
        $this->products = collect();
    }

    /**
     * 加入購物車
     * @param array $product 購買的商品
     * @return void
     */
    public function addItem(array $product)
    {
        $this->products->push($product);
    }

    /**
     * 計算運費
     * @return int
     */
    public function calDeliveryFee()
    {
        // 有抵達免運嗎？
        $deliverFeeStrategy = DeliverFeeStrategyFactory::create($this);
        if ($deliverFeeStrategy->isFree($this)) {
            return 0;
        }

        return 60;
    }
}
