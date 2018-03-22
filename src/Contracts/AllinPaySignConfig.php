<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:09
 */

namespace Bqdove\AllinPay\Contracts;

interface AllinPaySignConfig
{
    /**
     * 签名类型
     */
    const SIGN_TYPE = 0;

    /**
     * 返回一个生成签名的顺序数组
     * @return array
     */
    public static function getConstKey(): array;
}