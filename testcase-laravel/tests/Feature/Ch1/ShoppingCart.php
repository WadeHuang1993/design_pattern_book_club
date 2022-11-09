<?php

namespace Tests\Feature\Ch1;

class ShoppingCart
{

    private $products;

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
        if ($this->products->sum('price') >= 1000) {
            return 0;
        }

        return 60;
    }
}
