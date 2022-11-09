<?php

namespace Tests\Feature\Ch1;

use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /**
     * 測試計算運費邏輯
     * @return void
     */
    public function testCalDeliveryFee()
    {
        $this->specify(
            '
            未滿免運額度 1000 元的商品；
            購物車計算運費時；
            運費為 60 元
            ',
            function () {
                /** @given 未滿免運額度 1000 元的商品； */
                $product = [
                    'productCode' => 'lays_cookie_box_100',
                    'name' => '樂事餅乾 10 包/箱',
                    'price' => 100,
                ];
                $shoppingCart = new ShoppingCart();
                $shoppingCart->addItem($product);
                $shoppingCart->addItem($product);

                /** @when 購物車計算運費時； */
                $deliveryFee = $shoppingCart->calDeliveryFee();

                /** @then 運費為 60 元 */
                self::assertEquals(60, $deliveryFee);
            }
        );

        $this->specify(
            '
            購買滿免運額度 1000 元的商品；
            購物車計算運費時；
            運費為免運 0 元
            ',
            function () {
                /** @given 購買滿免運額度 1000 元的商品； */
                $product = [
                    'productCode' => 'lays_cookie_box_500',
                    'name' => '樂事餅乾 50 包/箱',
                    'price' => 500,
                ];
                $shoppingCart = new ShoppingCart();
                $shoppingCart->addItem($product);
                $shoppingCart->addItem($product);

                /** @when 購物車計算運費時； */
                $deliveryFee = $shoppingCart->calDeliveryFee();

                /** @then 運費為免運 0 元 */
                self::assertEquals(0, $deliveryFee);
            }
        );

        $this->specify(
            '
            在 2022 聖誕夜購買一個「聖誕節禮品」；
            購物車計算運費時；
            限時活動購買任一「聖誕節禮品」則免運，運費為 0 元
            ',
            function () {
                /** @given 在 2022 聖誕夜購買一個「聖誕節禮品」 */
                $product = [
                    'productCode' => 'christmas_gift',
                    'name' => '迷你聖誕樹',
                    'price' => 100,
                ];
                $shoppingCart = new ShoppingCart();
                $shoppingCart->addItem($product);
                $shoppingCart->currentDate = '2022/12/24'; // 購買日為聖誕節

                /** @when 購物車計算運費時； */
                $deliveryFee = $shoppingCart->calDeliveryFee();

                /** @then 限時活動購買任一「聖誕節禮品」則免運，運費為 0 元 */
                self::assertEquals(0, $deliveryFee);
            }
        );
    }
}
