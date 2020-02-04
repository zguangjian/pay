<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 15:07
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\Gateways;


use zguangjian\Config;
use zguangjian\Contracts\GatewayApplicationInterface;

class Alipay implements GatewayApplicationInterface
{
    const MODE_NORMAL = "normal";

    const MODE_DEV = "dev";

    const URL = [
        self::MODE_NORMAL => 'https://openapi.alipay.com/gateway.do',
        self::MODE_DEV => 'https://openapi.alipaydev.com/gateway.do',
    ];

    protected $payload;

    protected $gateway;

    protected $extends;

    public function __construct(Config $config)
    {
        $this->gateway = Alipay::URL[$config->get('model', self::MODE_NORMAL)];
        $this->payload = [
            'app_id' => $config->get('app_id'),
            'method' => '',
            'format' => 'json',
            'charset' => 'utf-8',
            'sign_type' => 'RSA2',
            'version' => '1.0',
            'return_url' => $config->get('return_url'),
            'notify_url' => $config->get('notify_url'),
            'timestamp' => date('Y-m-d H:i:s'),
            'sign' => '',
            'biz_content' => [],
            'app_auth_token' => $config->get('app_auth_token'),
        ];
    }

}