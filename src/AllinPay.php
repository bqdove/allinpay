<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:07
 */

namespace Bqdove\AllinPay;

use Bqdove\AllinPay\Config\PaySign;
use Bqdove\AllinPay\Config\QuerySign;
use Bqdove\AllinPay\Config\ReceiveSign;
use Bqdove\AllinPay\Config\RefundSign;
use Bqdove\AllinPay\Supports\Encrypt;
use Bqdove\AllinPay\Supports\Form;
use Bqdove\AllinPay\Traits\HttpSocketTrait;
use Bqdove\AllinPay\Traits\ServiceTrait;
use Symfony\Component\HttpFoundation\Request;
use Bqdove\AllinPay\Supports\Collection;
use Bqdove\AllinPay\Exceptions\InvalidSignException;


class AllinPay
{
    use ServiceTrait;
    use HttpSocketTrait;

    /**
     * 通联支付参数
     * @var array
     */
    protected $config = [];

    /**
     * 初始化通联支付参数
     * AllinPay constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


    /**
     * 是否已经支付
     * @param array $order
     * @return bool
     * @throws Exceptions\HttpSocketException
     */
    public function isPaid(array $order): bool
    {
        $result = $this->find($order);
        if (!empty($result) && $result['payResult'] == 1) {
            return true;
        }
        return false;
    }


    /**
     * 根据订单号查询
     * @param array $order
     * @return Collection
     * @throws Exceptions\HttpSocketException
     */
    public function find(array $order): Collection
    {
        // 获取url字符串中的host字段
        $host = parse_url($this->config['payUrl'])['host'];

        $order['merchantId'] = $this->config['merchantId'];     // 商户ID
        $order['version'] = QuerySign::VERSION;                 // 查询接口版本号
        $order['signType'] = PaySign::SIGN_TYPE;                // 签名方式
        $order['queryDatetime'] = date('YmdHis', time());// 查询日期

        // 签名
        $order['signMsg'] = Encrypt::MD5_sign($this->sort(QuerySign::getConstKey(), $order), $this->config['key']);

        // 发起报文请求并返回结果数据
        return new Collection(HttpSocketTrait::httpPost($host, QuerySign::URL_PATH, $order));

    }


    /**
     * 退款
     * @param array $order
     * @return Collection
     * @throws Exceptions\HttpSocketException
     */
    public function refund(array $order): Collection
    {
        // 获取url字符串中的host字段
        $host = parse_url($this->config['payUrl'])['host'];

        $order['merchantId'] = $this->config['merchantId'];     // 商户ID
        $order['version'] = RefundSign::VERSION;                // 退款接口版本号
        $order['signType'] = PaySign::SIGN_TYPE;                // 签名方式

        // 签名
        $order['signMsg'] = Encrypt::MD5_sign($this->sort(RefundSign::getConstKey(), $order), $this->config['key']);

        // 发起报文请求并返回结果数据
        return new Collection(HttpSocketTrait::httpPost($host, QuerySign::URL_PATH, $order));
    }


    /**
     * 验证异步回调的签名
     * @param array $receiveData 通联异步通知POST过来的数据
     * @return bool
     */
    public function verifySign(array $receiveData): bool
    {
        // 验证签名是否一致
        return $receiveData['signMsg'] == Encrypt::MD5_sign(self::sort(ReceiveSign::getConstKey(), $receiveData), $this->config['key']);
    }

    /**
     * 验签名
     * @return Collection
     * @throws InvalidSignException
     */
    public function verify()
    {
        // 从请求中获取数据
        $request = Request::createFromGlobals();

        // 将请求中的数据转换为数组，并存入$data中
        parse_str($request->getContent(), $data);

        if ($this->verifySign($data)) {

            // 返回通联异步通知的数据对象
            return new Collection($data);
        }

        throw new InvalidSignException('通联支付签名异常', 3, $data);
    }


    /**
     * 通联支付调取收银台
     * @param array $order
     * @return string
     */
    public function pay(array $order): string
    {
        // 设置支付参数
        PaySign::setPayParams($this->config);

        // 获取支付相关的参数
        $params = PaySign::getPayParams();

        // 将支付必须参数和订单参数合并
        $params = array_merge($params, $order);

        // 生成签名
        $params['signMsg'] = Encrypt::MD5_sign(self::sort(PaySign::getConstKey(), $params), $this->config['key']);

        // 生成post形式的form表单
        return Form::buildRequestHtml($params, $this->config['payUrl']);
    }
}