<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 14:49
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\Contracts;


interface GatewayApplicationInterface
{
    /**
     * @param string $gateway
     * @param array $params
     * @return Collection|Response
     */
    public function pay($gateway, $params);

    /**
     * Query an order.
     * @param string|array $order
     * @param string $type
     * @return Collection
     */
    public function find($order, string $type);

    /**
     * Refund an order.
     * @param array $order
     * @return Collection
     */
    public function refund(array $order);

    /**
     * Cancel an order.
     * @param string|array $order
     * @return Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     * @param string|array $order
     * @return Collection
     */
    public function close($order);

    /**
     * Verify a request.
     * @param string|array|null $content
     * @param bool $refund
     * @return Collection
     */
    public function verify($content, bool $refund);

    /**
     * Echo success to server.
     * @return Response
     */
    public function success();
}