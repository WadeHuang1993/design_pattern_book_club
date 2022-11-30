# 第 3 章 創建型模式

「創建型模式」物件的抽象了實例化過程。

它們幫助一個系統把物件的「如何創建、如何組合」獨立出來

```php
/**
 * 建立藍新金流的 Client
 * @return PaymentClient
 */
use PaymentClients\NewebPayClient;public function getEcPayPaymentClient($roomId): PaymentClient
{
	 // 從 DB 取得第三方金流的的金鑰
        $config = PaymentMethodConfigRepository::getItem(
            $projectCode,
            $paymentMethod,
            $platform
        );

        $paymentConfig = new NewebPayConfig($config);
        return new NewebPayClient($paymentConfig);
}
```

一個類創建型模式使用繼承改變被實例化的類別：
- Factory Method

```php
use PaymentClients\NewebPayClient;interface PaymentClientFactory {
   /**
   * 建立第三方金流的 Client
   * @return PaymentClient
   */
    public function create(): PaymentClient;
}

class NewebPaymentClientFactory implements PaymentClientFactory {
   /**
   * 建立藍新金流的 Client
   * @return PaymentClient
   */
    public function create(): PaymentClient
    {
    	 // 從 DB 取得第三方金流的的金鑰
        $config = PaymentMethodConfigRepository::getItem(
            $projectCode,
            $paymentMethod,
            $platform
        );

        $paymentConfig = new NewebPayConfig($config);
        return new NewebPayClient($paymentConfig);
    }
}
```

而一個物件創建型模式將實例化過程委託給另一個物件：

- Abstract Factory
- Builder
- Prototype
- Singleton

```php
use NewebPaymentClientFactory;

class EcpayPaymentClientSingleton
{
    private PaymentClient $paymentClient;

    /**
     * 建立藍新金流 PaymentClient
     * 確保系統
     *
     * @return \PaymentClient	
     */
    public function create(): PaymentClient
    {
        // 系統已經建立過物件了嗎？
        if ($this->paymentClient) {
            return $this->paymentClient;
        }

        // 實例化物件，並且儲存到單例模式類別的記憶體中
        $factory = new NewebPaymentClientFactory();
        $this->paymentClient = $factory->create();
        return $this->paymentClient;
    }
}
```

隨著系統演化得越來越依賴於組合而不是類別繼，創建型模式變得更為重要。

重心從對一組固定行為的硬編碼（hard-coding）轉移為定義一個**較小的基本行為集**，  
這些行為可以被組合成任意數目的更複雜的行為。

在這些模式中有兩個不斷出現的主旋律：

第一：它們都將關於該系統使用哪些具體的類別的信息封裝起來。
- 系統只依賴 interface，而不是依賴特定的演算法實例以便未來擴充。

第二：它們隱藏了這些類別的實例化是如何被創建和放在一起的。
- 把實例化的過程封裝起來了

整個系統關於這些物件所知道的由抽像類別所定義的接口。
- 對系統來說只需依賴 Interface，而不是特定的實例。

因此，創建型模式在「**創建什麼、由誰來創建、如何創建、何時創建**」提供靈活性。
它們允許你用結構和功能差別很大的“產品”物件配置一個系統。
配置可是靜態的(即在編譯時指定),也可以是動態的(在運行時)。

有時創建型模式是相互競爭的。
例如,在有些情況下 Prototype(3.4 )或 AbstractFactory(3.1) 用起來都很好。

而在另外一些情況下它們是互補的Builder(3.2)可以使用其他模式去實現某個構件的創建。
Prototype(3.4)可以在它的實現中使用Singleton(3.5）。
