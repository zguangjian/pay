<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 15:07
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src\Gateways;


use zguangjian\Config;
use zguangjian\Contracts\GatewayApplicationInterface;
use zguangjian\Contracts\GatewayInterface;
use zguangjian\Exceptions\InvalidGatewayException;

/**
 * @method Response app(array $config) APP 支付
 * @method Collection pos(array $config) 刷卡支付
 * @method Collection scan(array $config) 扫码支付
 * @method Collection transfer(array $config) 帐户转账
 * @method Response wap(array $config) 手机网站支付
 * @method Response web(array $config) 电脑支付
 * @method Collection mini(array $config) 小程序支付
 */
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

    public function __call($method, $params)
    {
        if (isset($this->extends[$method])) {
            return $this->makeExtend($method, ...$params);
        }
        return $this->pay($method, ...$params);
    }


    public function pay($gateway, $params = [])
    {
        $this->payload['return_url'] = $params['return_url'] ?? $this->payload['return_url'];
        $this->payload['notify_url'] = $params['notify_url'] ?? $this->payload['notify_url'];

        unset($params['return_url'], $params['notify_url']);

        $this->payload['biz_content'] = json_encode($params);
        $gateway = get_class($this) . '\\' . ucfirst($gateway) . 'Gateway';


        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }
        throw new InvalidGatewayException("Pay Gateway [{$gateway}] not exists");
    }

    public function makePay($gateway)
    {
        $app = new $gateway();
        if ($app instanceof GatewayInterface) {
            return $app->pay($this->gateway, array_filter($this->payload, function ($value) {
                return $value !== '' && !is_null($value);
            }));
        }
        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Must Be An Instance Of GatewayInterface");
    }

    public function find($order, string $type)
    {
        // TODO: Implement find() method.
    }

    public function refund(array $order)
    {
        // TODO: Implement refund() method.
    }

    public function cancel($order)
    {
        // TODO: Implement cancel() method.
    }

    public function close($order)
    {
        // TODO: Implement close() method.
    }

    public function verify($content, bool $refund)
    {
        // TODO: Implement verify() method.
    }

    public function success()
    {
        // TODO: Implement success() method.
    }

}