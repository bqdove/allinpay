<?php
/**
 * Created by PhpStorm.
 * User: HouJie
 * Date: 2018-1-18
 * Time: 19:56
 */


namespace Bqdove\AllinPay\Traits;

use Bqdove\AllinPay\Exceptions\HttpSocketException;

trait HttpSocketTrait
{
    /**
     * POST方式的报文
     * @param string $host
     * @param string $path
     * @param array $data
     * @return array
     * @throws HttpSocketException
     */
    final public static function httpPost(string $host, string $path, array $data)
    {
        $params = http_build_query($data);
        $length = strlen($params);

        $header = array();
        $header[] = 'POST ' . $path . ' HTTP/1.0';
        $header[] = 'Host: ' . $host;
        $header[] = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html,text/plain,image/png,image/jpeg,image/gif,*/*';
        $header[] = 'Accept-encoding: gzip';
        $header[] = 'Accept-language: zh-CN,zh;q=0.9';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Content-Length: ' . $length;

        $request = implode("\r\n", $header) . "\r\n\r\n" . $params;

        $pageContents = "";
        if (strpos($host, "ceshi") !== false) {
            $fp = fsockopen($host, 80, $errno, $errstr, 10);//测试环境请换用fsockopen($host, 80, $errno, $errstr, 10)
        } else {
           $fp= pfsockopen('ssl://'.$host, 443, $errno, $errstr, 10); //生产环境请换用pfsockopen('ssl://'.$host, 443, $errno, $errstr, 10)
        }

        if (!$fp) {
            throw new HttpSocketException('无法连接通联支付服务器');
        }

        fwrite($fp, $request);
        $inHeaders = true;//是否在返回头
        $atStart = true;//是否返回头第一行
        $ERROR = false;
        while (!feof($fp)) {
            $line = fgets($fp, 2048);

            if ($atStart) {
                $atStart = false;
                preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m);
                $responseStatus = $m[2];
                continue;
            }

            if ($inHeaders) {
                if (strLen(trim($line)) == 0) {
                    $inHeaders = false;
                }
                continue;
            }

            if (!$inHeaders and $responseStatus == 200) {
                //获得参数串
                $pageContents = $line;
            }
        }
        fclose($fp);


        $resultArr = array();
        $result = explode('&', $pageContents);

        if (is_array($result)) {
            foreach ($result as $element) {
                $temp = explode('=', $element);
                if (count($temp) == 2) {
                    $resultArr[$temp[0]] = $temp[1];
                }
            }
        }

        return $resultArr;
    }
}