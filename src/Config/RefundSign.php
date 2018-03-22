<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:19
 */

namespace Bqdove\AllinPay\Config;

use Bqdove\AllinPay\Contracts\AllinPaySignConfig;

/**
 * 退款
 * Class RefundSign
 * @package App\PayChannels\AllinPay\Config
 */
class RefundSign implements AllinPaySignConfig
{

    /**
     * 退款接口参数
     */
    const VERSION = 'v1.3';

    /**
     * 通联退款参数，必须按照下面的顺序，因为验签和是生成签名的参数都要按照这个顺序才能保证有效
     * @return array
     */
    public static function getConstKey(): array
    {
        return ['version', 'signType', 'merchantId', 'orderNo', 'refundAmount', 'orderDatetime', 'signMsg'];
    }
}