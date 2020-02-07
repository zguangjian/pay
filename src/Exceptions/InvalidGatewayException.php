<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/2/2
 * Time: 14:55
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\Exceptions;


class InvalidGatewayException extends Exception
{
    public function __construct($message, $raw = [])
    {
        parent::__construct('INVALID_GATEWAY: ' . $message, $raw, self::INVALID_GATEWAY);
    }
}