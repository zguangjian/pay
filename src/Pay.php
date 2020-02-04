<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/1/21
 * Time: 5:11
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src;

use zguangjian\Contracts\GatewayApplicationInterface;
use zguangjian\Exceptions\InvalidGatewayException;

class Pay
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public static function __callStatic($method, $param)
    {
        $app = new Self($param);
        return $app->create($method);
    }

    protected function create($method)
    {
        $gateway = __NAMESPACE__ . '\\src\\Gateways\\' . ucfirst($method);
        if (class_exists($gateway)) {
            return self::make($gateway);
        }
        throw new InvalidGatewayException("Gateway [{$method}] Not Exists");
    }

    protected function make($gateway)
    {
        $app = new $gateway;
        if ($app instanceof GatewayApplicationInterface) {
            return $app;
        }
        throw new InvalidGatewayException("Gateway [{$gateway}] Must Be An Instance Of GatewayApplicationInterface");
    }
}