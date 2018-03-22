<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 13:55
 */

namespace Bqdove\AllinPay\Traits;


use Bqdove\AllinPay\Supports\Arr;

trait ServiceTrait
{
    /**
     * 将$data中的数据按照 $contrastKey 里的顺序排序，并过滤掉值为空的
     * @param array $contrastKey
     * @param array $data
     * @return array
     */
    final public static function sort(array $contrastKey, array $data): array
    {
        $result = [];

        foreach ($contrastKey as $key) {
            $result[$key] = Arr::get($data, $key, '');
        }

        return array_filter($result, function ($value) {
            return $value !== '';
        }, ARRAY_FILTER_USE_BOTH);
    }
}