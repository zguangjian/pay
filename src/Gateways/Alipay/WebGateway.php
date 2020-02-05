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

    public function pay($endpoint, $payload)
    {
        $biz_array = json_decode($payload['biz_content'], true);
        $biz_array['product_code'] = self::$productCode;

        $method = $biz_array['http_method'] ?? 'POST';
        unset($biz_array['http_method']);

        $payload['method'] = $method;
        $payload['biz_content'] = json_encode($biz_array);
        $payload['sign'] = Support::generateSign($payload);
    }
}