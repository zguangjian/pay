<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/5
 * Time: 11:16
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src\Gateways\Alipay;


use zguangjian\Config;
use zguangjian\src\Gateways\Alipay;

class Support
{
    protected $config;

    protected $baseUri;

    private static $instance;

    public function __construct(Config $config)
    {
        $this->baseUri = Alipay::URL[$config->get('model', Alipay::MODE_NORMAL)];
        $this->config = $config;
    }

    public function __get($name)
    {
        return $this->getConfig($name);
    }

    public static function create(Config $config)
    {
        dd($config);
        if (php_sapi_name() === 'cli' || (self::$instance instanceof self)) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function getConfig($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config->all();
        }
        if ($this->config->has($key)) {
            return $this->config->get($key);
        }
        return $default;
    }

    public static function generateSign($payload)
    {
        dd(self::$instance);
       $private_key = self::$instance->private_key;

    }
}