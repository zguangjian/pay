<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/5
 * Time: 10:32
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src\Gateways\Alipay;


use zguangjian\Config;
use zguangjian\Contracts\GatewayInterface;
use zguangjian\src\Gateways\Alipay;

class WebGateway implements GatewayInterface
{
    protected static $productCode = "FAST_INSTANT_TRADE_PAY";

    protected $method = "alipay.trade.page.pay";

    public function pay($endpoint, $payload)
    {
        $biz_array = json_decode($payload['biz_content'], true);
        $biz_array['product_code'] = self::$productCode;

        $method = $biz_array['http_method'] ?? 'POST';
        unset($biz_array['http_method']);

        $payload['method'] = $this->method;
        $payload['biz_content'] = json_encode($biz_array);
        $payload['sign'] = Support::generateSign($payload);
        $html = $this->buildPayHtml($endpoint, $payload, $method);
        echo $html;
    }

    protected function buildPayHtml($uri, $param, $method = "POST")
    {
        if (strtoupper($method) == 'GET') {
            return $uri . '&' . http_build_query($param);
        }
        $html = "<form id='alipay_submit' name='alipay_submit' action='$uri' method='$method'>";
        foreach ($param as $key => $value) {
            $value = str_replace("'", '&apos;', $value);//防止存在'替换为apos
            $html .= "<input type='hidden' name='$key' value='$value'>";
        }
        $html .= "<input type='submit' value='ok' style='display:none;'></form>";
        $html .= "<script>document.forms['alipay_submit'].submit();</script>";
        return Response::create($sHtml);
    }
}