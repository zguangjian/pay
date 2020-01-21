<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/1/21
 * Time: 5:11
 * Email: zguangjian@outlook.com
 */

namespace zguangjian;


use zguangjian\src\Alipay;
use zguangjian\src\Wechat;

class Pay
{
    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public function driver($method = 'alipay')
    {
        switch ($method) {
            case 'alipay':
                return new Alipay($this->config);
                break;
            case 'wechat':
                return new Wechat($this->config);
                break;
            default;
        }
    }
}