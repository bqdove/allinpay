<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 20:41
 */

namespace Bqdove\AllinPay\Supports;


use Bqdove\AllinPay\Config\PaySign;
use Bqdove\AllinPay\Traits\ServiceTrait;

class Form
{
    use ServiceTrait;

    /**
     * 生成请求通联收银台的html
     * @param array $data 表单数据
     * @param string $pay_url 表单提交的URL地址
     * @return string
     */
    final public static function buildRequestHtml(array $data, string $pay_url)
    {
        $data = self::sort(PaySign::getConstKey(), $data);
        $formHtml = '';

        $formHtml .= '<form id="submit" name="submit" action="' . $pay_url . '" method="post">';
        foreach ($data as $key => $value) {
            $formHtml .= '<input type="hidden" name="' . $key . '" value="' . $value . '"/>';
        }
        $formHtml .= '<input type="submit" value="ok" style="display: none;">';
        $formHtml .= '</form>';
        $formHtml .= "<script>document.forms['submit'].submit();</script>";

        return $formHtml;
    }
}