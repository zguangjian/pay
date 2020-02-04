<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/1/21
 * Time: 5:11
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src;

use zguangjian\Config;
use zguangjian\Contracts\GatewayApplicationInterface;
use zguangjian\Exceptions\InvalidGatewayException;
use zguangjian\src\Gateways\Alipay;

/**
 * @method static Alipay alipay(array $config) 支付宝
 * @method static Wechat wechat(array $config) 微信
 */
class Pay
{
    protected $config;

    public function __construct($config)
    {
        $this->config = new Config($config);
    }

    public static function __callStatic($method, $params)
    {
        $app = new self(...$params);
        return $app->create($method);
    }

    protected function create($method)
    {
        $gateway = __NAMESPACE__ . '\\Gateways\\' . ucfirst($method);

        if (class_exists($gateway)) {
            return self::make($gateway);
        }
        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    protected function make($gateway)
    {
        $app = new $gateway($this->config);
        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }
        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }
}