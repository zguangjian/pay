<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 14:49
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\Contracts;


interface GatewayInterface
{
    /**
     * Pay an order.
     * @param string $endpoint
     * @param array  $payload
     * @return Collection|Response
     */
    public function pay($endpoint, $payload);
}