# 3.3 Factory Method (工廠方法)

1. 意圖

定義生成物件的介面，但讓子類別決定該實體化哪種類別的物件。
讓類別把實體化的程序推遲給子類別去實作。

"Define an interface for creating an object, but let subclasses decide which class to instantiate. 
The Factory method lets a class defer instantiation it uses to subclasses."


1. 模式名稱 (pattern name)  
   一個助記名，允許我們在較高的抽象層次上進行其他人交流。
   Factory Method (工廠方法)

2. 問題 (problem)
   解釋了設計問題和問題存在的前因後果，  
   它可能描述了特定的設計問題，如怎樣使用物件表示演算法等、  
   也可能描述了**導致不靈活設計**的程式結構。

```
   系統在建立第三方金流 Client 時，需要因應不同的平台執行不同的初始化邏輯。
   這些初始化的邏輯若散落在系統各處，到時候要更換金流平台時就需要調整很多地方。
```

3. 解決方案 (solution)  
   描述了設計的組成成分，以及它們之間的**互相關係**及**各自的職責**和**協作方式**。  
   因為模式就像一個範本，可應用於種不同場合，  
   所以**解決方案並不描述一個特定而具體的設計或實現**，  
   **而提供設計問題的抽象描述，和怎樣用具有意義的元素組合來解決問題**。
   

4. 效果 (consequences)  
   描述了模式的效果與 **權衡**。  
   引入每一個模式都有成本，增加一些理解的複雜度，  
   以換取對系統的「靈活性、擴充性或可移植性」，  
   使用模式之前，慎重考慮上述這些影響與權衡將會很有幫助。
