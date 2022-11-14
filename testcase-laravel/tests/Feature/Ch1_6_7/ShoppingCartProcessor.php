<?php

namespace App\Calculator;

use App\Calculator\ShoppingCarHandlers\CouponDiscount;
use App\Calculator\ShoppingCarHandlers\DeliveryFeeDiscount;
use App\Calculator\ShoppingCarHandlers\MarkBookEventDiscountRate;
use App\Calculator\ShoppingCarHandlers\MarkBookEventTags;
use App\Calculator\ShoppingCarHandlers\NormalMemberDiscount;
use App\Calculator\ShoppingCarHandlers\MarkCombineBookTags;
use App\Models\ProductType;
use App\Repositories\SystemProductRepository;
use App\Services\BookEvents\BookEventDiscountActiveChecker;
use App\Services\BookEvents\BookEventService;
use App\ValueObjects\ShoppingCart;
use App\ValueObjects\ShoppingCarts\Product;
use App\ValueObjects\ShoppingCarts\UserCoupon;
use App\ValueObjects\SystemProduct;

/**
 * 這個類別用來計算購物車的優惠折扣、運費
 */
class ShoppingCartProcessor
{
    /**
     * 計算購物車的數據
     * 供前台購物車頁面渲染
     *
     * @param ShoppingCart $cart
     * @return CalculatedShoppingCart
     */
    public static function run(ShoppingCart $shoppingCart): CalculatedShoppingCart
    {
        // 取得購物車內的商品
        $cart = new CalculatedShoppingCart($shoppingCart->getProductContent(), $shoppingCart->getCoupon(), $shoppingCart->getCount(),);
        $products = $cart->getProducts();

        /** 標記書展折扣％數 */
        $discountActiveChecker = new BookEventDiscountActiveChecker();
        // 若符合書展條件的話，替書籍押上書展優惠折扣
        if (false === $discountActiveChecker->isCartContainEventBooks($cart)) {
            $discountActiveChecker->setBookEventDiscount($cart);
        }

        /** 押上書展 tags */
        // 購物車有書展的商品嗎？
        $bookEventMap = BookEventService::makeProductAndBookEventMap();
        $hasBookEventProduct = $products->filter(function ($book) use ($bookEventMap) {
            return in_array($book->id, $bookEventMap);
        });
        if ($hasBookEventProduct) {
            foreach ($products as $product) {
                /** @var Product $product */
                // 這本書有參與任何書展嗎？
                $bookEvents = $bookEventMap[$product->id] ?? [];

                if ($bookEvents) {
                    // 若有的話擴充 bookEventTags 欄位
                    foreach ($bookEvents as $eventId) {
                        $tag = BookEventService::getTagWithDiscountForPage($eventId);
                        $product->addBookEventTags($tag);
                        $product->addBookEventIdForTags($eventId);
                    }
                }
            }
        }

        /** 押上套書 tags */
        $products = $cart->getProducts()
            ->filter(function (Product $product) {
                return ProductType::isCombineBook($product->model);
            });

        foreach ($products as $product) {
            /** @var Product $product */
            $combineProduct = $product->model;
            // 若有的話擴充 bookEventTags 欄位
            $tag = [
                'link' => route('books.showCombineBook', ['productShortId' => $combineProduct->product_short_id]),
                'title' => $combineProduct->name,
                'discount' => $combineProduct->discount,
                'giftBadges' => $combineProduct->gift_badges,
            ];
            $product->addCombineBooksTags($tag);
        }

        /** 一般會員 79 折優惠 */
        $products->each(function (Product $product) {
            $sellingPrice = $product->productValueObject->sellingPrice;
            $discountRate = $product->productValueObject->discount;
            // 如果這個產品沒有折扣，則使用一般會員則折扣
            if (empty($product->discountRate)) {
                $product->setDiscountRate($discountRate);
                $product->setSellingPrice($sellingPrice);
            }

            // 如果一般會員折扣小於產品的折扣，則取得折扣
            if ($discountRate < $product->discountRate) {
                $product->setDiscountRate($discountRate);
                $product->setSellingPrice($sellingPrice);
            }
        });

        /** 優惠券折扣 */
        // 取得已經套用的優惠券
        $couponDiscounts = self::getCouponDiscounts($cart);
        // 取得購物車中可以被折扣的商品
        $products = $cart->getProductsForCalDiscount();

        $couponPrice = 0;
        $products->each(function (Product $product) use (&$couponPrice, $couponDiscounts) {
            $couponDiscounts->each(function (UserCoupon $couponDiscount) use (&$couponPrice, $product) {
                $discountRate = $couponDiscount->getDiscount();
                $discountPrice = $product->calDiscount($discountRate);
                // 如果這個產品沒有折扣，則使用優惠卷折扣
                if (empty($product->discountRate)) {
                    $couponPrice += ($product->sellingPrice - $discountPrice) * $product->quantity;
                }
                // 如果優惠卷折扣小於產品的折扣，則取得折扣
                if ($discountRate < $product->discountRate) {
                    $couponPrice += ($product->sellingPrice - $discountPrice) * $product->quantity;
                }
            });
        });
        $cart->setCouponPrice($couponPrice);
        $cart->updateCoupon($couponDiscounts);

        /** 免運費優惠 */
        // 取得當前條件可使用的運費
        $systemProduct = SystemProductRepository::getSystemProductByName($deliverFee->systemProductName());
        $systemProduct = new SystemProduct($systemProduct);
        $systemProduct->setTitle($deliverFee->name());
        $cart->setDeliveryFees(collect([$systemProduct]));

        return $cart;
    }
}
