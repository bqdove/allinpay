<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:15
 */

namespace Bqdove\AllinPay\Config;

use Bqdove\AllinPay\Contracts\AllinPaySignConfig;

/**
 * 支付签名验证
 * Class PaySign
 * @package App\PayChannels\AllinPay\Config
 */
class PaySign implements AllinPaySignConfig
{

    const VERSION = 'v1.0';
    const PAY_TYPE = 0;
    const TRADE_NATURE = 'GOODS';
    const INPUT_ChARSET = 1;

    /**
     * 支付所需参数
     * @var array
     */
    private static $payParams = [
        'inputCharset' => self::INPUT_ChARSET,
        'pickupUrl' => '',
        'receiveUrl' => '',
        'version' => self::VERSION,
        'signType' => self::SIGN_TYPE,
        'merchantId' => '',
        'payType' => self::PAY_TYPE,
        'tradeNature' => self::TRADE_NATURE,
    ];

    /**
     * 返回支付参数
     * @return array
     */
    public static function getPayParams(): array
    {
        return self::$payParams;
    }

    /**
     * 修改支付参数
     * @param array $params
     */
    public static function setPayParams(array $params): void
    {
        foreach ($params as $key => $param) {

            // 检测key是否存在
            if (array_key_exists($key, self::$payParams)) {

                // 修改支付参数
                self::$payParams[$key] = $param;
            }
        }
    }

    /**
     * 通联支付参数，必须按照下面的顺序，因为验签和是生成签名的参数都要按照这个顺序才能保证有效
     * @return array
     */
    public static function getConstKey(): array
    {
        return ['inputCharset', 'pickupUrl', 'receiveUrl', 'version', 'language', 'signType', 'merchantId', 'payerName', 'payerEmail', 'payerTelephone', 'payerIDCard', 'pid', 'orderNo', 'orderAmount', 'orderCurrency', 'orderDatetime', 'orderExpireDatetime', 'productName', 'productPrice', 'productNum', 'productId', 'productDesc', 'ext1', 'ext2', 'extTL', 'payType', 'issuerId', 'pan', 'tradeNature', 'signMsg'];
    }
}