# AllinPay 通联支付说明

**请先熟悉 通联支付 开发文档！**


# QuickReference

## 支付
```php
   use Bqdove\AllinPay\AllinPay;
   
   // 配置
   $config = [
        'payUrl' => 'http://ceshi.allinpay.com/gateway/index.do',
        'pickupUrl' => "http://www.test.com/return_callback",
        'receiveUrl' => "http://www.test.com/notify",
        'merchantId' => '100020091218001',
        'key' => '1234567890'
   ];

    // 订单
    $order = [
        'orderNo' => '0001201213',
        'orderAmount' => 100,
        'orderDatetime' => date('YmdHis', time()), // 订单提交时间
        'productName' => "测试的商品"
    ];

    // 支付 呼起通联收银台
    $allinpay = new AllinPay($config);
    echo $allinpay->pay($order);

    
    
```

## 查询
```php
    use Bqdove\AllinPay\AllinPay;
    
    $config = [
        'payUrl' => 'http://ceshi.allinpay.com/gateway/index.do',
        'pickupUrl' => "http://www.test.com/return_callback",
        'receiveUrl' => "http://www.test.com/notify",
        'merchantId' => '100020091218001',
        'key' => '1234567890'
    ];
    
    $order = [
        "orderNo" => "0001201212",
        "orderDatetime" => "20180322083745"
    ];
    
    $allinpay = new AllinPay($config);
    try {
        $result = $allinpay->find($order);
        echo "<pre>";
        var_dump($result);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    返回结果：
    Ibeach\Supports\Collection Object
    (
        [items:protected] => Array
            (
                [credentialsType] => 
                [payAmount] => 100
                [extTL] => 
                [payDatetime] => 20180322163633
                [signType] => 0
                [returnDatetime] => 20180322171210
                [credentialsNo] => 
                [paymentOrderId] => 201803221632204938
                [pan] => 
                [version] => v1.0
                [issuerId] => 
                [orderNo] => 0001201212
                [payResult] => 1
                [ext1] => 
                [ext2] => 
                [orderAmount] => 100
                [signMsg] => F8D2E1E4278FAFCCAEC35F71E4F15B2A
                [txOrgId] => 
                [errorCode] => 
                [userName] => 
                [payType] => 0
                [merchantId] => 100020091218001
                [language] => 1
                [orderDatetime] => 20180322083745
            )
    
    )
    
```
订单查询，返回 Collection 类型，可以通过 `$collection->xxx` 得到服务器返回的数据。

## 退款
```php
    use Bqdove\AllinPay\AllinPay;
    
    $config = [
        'payUrl' => 'http://ceshi.allinpay.com/gateway/index.do',
        'pickupUrl' => "http://www.test.com/return_callback",
        'receiveUrl' => "http://www.test.com/notify",
        'merchantId' => '100020091218001',
        'key' => '1234567890'
    ];
    
    $order = [
        'orderNo' => '0001201212',                            // 商户订单号
        'refundAmount' => 100, // 退款金额
        'orderDatetime' => '20180322083745',              // 订单创建时间
    ];
    
    
    $allinpay = new AllinPay($config);
    try{
        $result = $allinpay->refund($order);
        echo "<pre>";
        print_r($result);
    }catch (Exception $exception) {
    
    }
    
    返回结果：
    Ibeach\Supports\Collection Object
    (
        [items:protected] => Array
            (
                [merchantId] => 100020091218001
                [version] => v1.3
                [signType] => 0
                [orderNo] => 0001201212
                [orderAmount] => 10000
                [orderDatetime] => 20180322083745
                [refundAmount] => 10000
                [refundDatetime] => 20180322171848
                [refundResult] => 20
                [returnDatetime] => 20180322170944
                [signMsg] => 6B88885BAB3306DB1EBC889C2C5D4883
            )
    
    )
    返回 Collection 类型，可以通过 `$collection->xxx` 得到服务器返回的数据。
```


    

