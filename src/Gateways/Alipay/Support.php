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
use zguangjian\Exceptions\InvalidGatewayException;
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
        if (php_sapi_name() === 'cli' || !(self::$instance instanceof self)) {
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

    //生成sign
    public static function generateSign($payload)
    {
        $private_key = self::$instance->private_key;
        if (is_null($private_key)) {
            throw new InvalidGatewayException('Missing Alipay Config -- [private_key]');
        }
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($private_key, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        //生成sign

        openssl_sign(self::getSignContent($payload), $sign, $private_key, OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
        if (is_resource($private_key)) {
            openssl_free_key($private_key);
        }
        return $sign;
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    public static function getSignContent($param = [], $verify = false)
    {
        ksort($param);
        $strToBeSign = "";
        foreach ($param as $key => $value) {
            if (!$verify && $value != "" && !is_null($value) && $key != 'sign' && '@' != substr($value, 0, 1)) {
                $strToBeSign .= $key . "=" . $value . '&';
            }

            if ($verify && $key != 'sign' && $key != 'sign_type') {
                $strToBeSign .= $key . '=' . $value . '&';
            }
        }
        return trim($strToBeSign, '&'); //返回 去掉头尾&符号的字符串
    }
}