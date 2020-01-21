<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/1/21
 * Time: 5:18
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src;


use zguangjian\Alipay\AlipayConfig;

class Alipay
{
    /**
     * 支付宝提供的 APP_ID
     * @var $app_id
     */
    protected $app_id;
    /**
     * 异步回调地址
     * @var $notify_url
     */
    protected $notify_url;
    /**
     * 同步回调地址
     * @var $return_url
     */
    protected $return_url;
    /**
     * 支付宝公钥
     * @var $ali_public_key
     */
    protected $ali_public_key;

    /**
     * 私钥
     * @var $private_key
     */
    protected $private_key;

    /**
     * 请求地址
     * @var $gatewayUrl
     */
    protected $gatewayUrl;

    /**
     * 必填参数
     * @var array
     */
    protected $param = [];


    public function __construct($config)
    {
        extract($config);
    }

    /**
     * 网页支付
     */
    public function gateway()
    {
        $this->gatewayUrl = AlipayConfig::gatewayUrl;
        $this->param = [
            'app_id' => $this->app_id,
            'method' => AlipayConfig::method,
            'charset' => AlipayConfig::charset,
            'sign_type' => AlipayConfig::sign_type,
            'sign' => $this->ali_public_key,
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => AlipayConfig::version,
        ];

    }

    /**
     * 选择沙箱测试模式
     */
    public function dev()
    {
        $this->gatewayUrl = AlipayConfig::gatewayDevUrl;
    }

    public function pay($config_biz = [])
    {
        $config_biz['product_code'] = "QUICK_WAP_WAY";
        $config_biz['quit_url'] = $_SERVER['url'];
        $this->param = array_merge($this->param, ['biz_content' => $config_biz]);
        return $this->gatewayUrl . '?' . http_build_query($this->param);
    }
}