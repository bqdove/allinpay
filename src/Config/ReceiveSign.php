<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:13
 */

namespace Bqdove\AllinPay\Config;

use Bqdove\AllinPay\Contracts\AllinPaySignConfig;


/**
 * 异步通知校验签名
 * Class ReceiveSign
 * @package App\PayChannels\AllinPay\Config
 */
class ReceiveSign implements AllinPaySignConfig
{

    /**
     * 返回一个生成签名的顺序数组
     * @return array
     */
    public static function getConstKey(): array
    {
        return [
            'merchantId', 'version', 'language', 'signType', 'payType', 'issuerId', 'paymentOrderId', 'orderNo', 'orderDatetime', 'orderAmount', 'payDatetime', 'payAmount', 'ext1', 'ext2', 'payResult', 'errorCode', 'returnDatetime'
        ];
    }
}