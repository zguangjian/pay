<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 15:07
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src\Gateways;

use zguangjian\Contracts\GatewayApplicationInterface;

class Wechat implements GatewayApplicationInterface
{
    public function __construct()
    {

    }

    public function __call($gateway, $params)
    {
        // TODO: Implement __call() method.
    }

    public function cancel($order)
    {
        // TODO: Implement cancel() method.
    }

    public function find($order, string $type)
    {
        // TODO: Implement find() method.
    }

    public function pay($gateway, $params)
    {
        // TODO: Implement pay() method.
    }

    public function verify($content, bool $refund)
    {
        // TODO: Implement verify() method.
    }

    public function close($order)
    {
        // TODO: Implement close() method.
    }

    public function success()
    {
        // TODO: Implement success() method.
    }

    public function refund(array $order)
    {
        // TODO: Implement refund() method.
    }

}