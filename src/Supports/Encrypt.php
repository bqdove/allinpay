<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 11:33
 */

namespace Bqdove\AllinPay\Supports;

class Encrypt
{
    /**
     * MD5签名
     * @param array $args
     * @param string $key
     * @return string
     */
    public static function MD5_sign(array $args, string $key): string
    {
        $args['key'] = $key;
        $url_params = urldecode(http_build_query($args));

        return strtoupper(md5($url_params));
    }
}

