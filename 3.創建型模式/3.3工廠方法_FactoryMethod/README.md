# 3.3 Factory Method (工廠方法)

使用情境：
- [feat:[第3章] 3.3 章建立一筆交易](https://github.com/WadeHuang1993/design_pattern_book_club/commit/25f74e9a2056d72d81a6a8eba9af2dc89137dbf6)
- [refactor:[第3章]重構 3.3 章建立一筆交易，導入 FactoryMethod](https://github.com/WadeHuang1993/design_pattern_book_club/commit/7f019ba0da5ffa241bd6a13196b102b88924aaa3)
- [refactor:[第3章]重構 3.3 章建立一筆交易，替其他付款方式導入 FactoryMethod](https://github.com/WadeHuang1993/design_pattern_book_club/commit/7c95f165c50b1affdba4228ee20144c0def14361)
- [feat:[第3章]替 FactoryMethod 加入 Hook 擴充初始化 PaymentClient 邏輯](https://github.com/WadeHuang1993/design_pattern_book_club/commit/4a85b1273e2a1e1efebf26bb800ab51697dd04e8)


意圖

定義生成物件的介面，但讓子類別決定該實體化哪種類別的物件。
讓類別把實體化的程序推遲給子類別去實作。

"Define an interface for creating an object, but let subclasses decide which class to instantiate. 
The Factory method lets a class defer instantiation it uses to subclasses."


### 1. 模式名稱 (pattern name)  
   Factory Method (工廠方法)

### 2. 問題 (problem)
   解釋了設計問題和問題存在的前因後果，  
   它可能描述了特定的設計問題，如怎樣使用物件表示演算法等、  
   也可能描述了**導致不靈活設計**的程式結構。

- [@see feat:[第3章] 3.3 章建立一筆交易](https://github.com/WadeHuang1993/design_pattern_book_club/commit/25f74e9a2056d72d81a6a8eba9af2dc89137dbf6)


```
   系統在建立第三方金流 Client 時，需要因應不同的平台執行不同的初始化邏輯。
   這些初始化的邏輯若散落在系統各處，到時候要更換金流平台時就需要調整很多地方。
```

### 3. 解決方案 (solution)  
   描述了設計的組成成分，以及它們之間的**互相關係**及**各自的職責**和**協作方式**。  
   因為模式就像一個範本，可應用於種不同場合，  
   所以**解決方案並不描述一個特定而具體的設計或實現**，  
   **而提供設計問題的抽象描述，和怎樣用具有意義的元素組合來解決問題**。
   
   
- [@see refactor:[第3章]重構 3.3 章建立一筆交易，導入 FactoryMethod](https://github.com/WadeHuang1993/design_pattern_book_club/commit/7f019ba0da5ffa241bd6a13196b102b88924aaa3)

```
進行一次重構，
將 PaymentClient 的初始化邏輯封裝至 PaymentClientFactory::create()，
讓系統不直接依賴特定的 PayClient，改成依賴 PaymentClient 介面。
```
   
![FactoryMethod 使用抽象介面](https://i.imgur.com/zoe7JIP.png)

### 4. 效果 (consequences)  
   描述了模式的效果與 **權衡**。  
   引入每一個模式都有成本，增加一些理解的複雜度，  
   以換取對系統的「靈活性、擴充性或可移植性」，  
   使用模式之前，慎重考慮上述這些影響與權衡將會很有幫助。
   
- [@see refactor:[第3章]重構 3.3 章建立一筆交易，替其他付款方式導入 FactoryMethod](https://github.com/WadeHuang1993/design_pattern_book_club/commit/7c95f165c50b1affdba4228ee20144c0def14361)
- [@see feat:[第3章]替 FactoryMethod 加入 Hook 擴充初始化 PaymentClient 邏輯](https://github.com/WadeHuang1993/design_pattern_book_club/commit/4a85b1273e2a1e1efebf26bb800ab51697dd04e8)

```
如此一來，  
未來需要變更「特定付款方式」的金流廠商時只需要維護 PaymentClientFactory::create() 一處即可，
不需要變更系統多處地方的程式碼了。

除此之外，也可以透過 **抽象類別** 的機制，來擴充實例化 PaymentClient 的邏輯。
```

![FactoryMethod 使用抽象類別](https://i.imgur.com/ws6oKVo.png)

