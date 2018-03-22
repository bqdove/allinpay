<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:34
 */

namespace Bqdove\AllinPay\Config;

use Bqdove\AllinPay\Contracts\AllinPaySignConfig;


/**
 * 查询签名配置
 * Class QuerySign
 * @package App\PayChannels\Allinpay\Config
 */
class QuerySign implements AllinPaySignConfig
{

    /**
     * 表示调用查询接口
     */
    const VERSION = 'v1.5';

    /**
     * 请求路径
     */
    const URL_PATH = '/gateway/index.do';

    /**
     * 通联查询参数，必须按照下面的顺序，因为验签和是生成签名的参数都要按照这个顺序才能保证有效
     * @return array
     */
    public static function getConstKey(): array
    {
        return ['merchantId', 'version', 'signType', 'orderNo', 'orderDatetime', 'queryDatetime', 'signMsg'];
    }
}