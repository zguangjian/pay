<?php
/**
 * Created by PhpStorm.
 * User: zguangjian
 * Date: 2020/1/21
 * Time: 7:24
 * Email: zguangjian@outlook.com
 */

namespace zguangjian\src\Alipay;


class Config
{
    /**
     * 正式支付接口url
     */
    const gatewayUrl = "https://openapi.alipay.com/gateway.do";
    /**
     * 沙箱支付借口url
     */
    const gatewayDevUrl = "https://openapi.alipaydev.com/gateway.do";
    /**
     * 接口名称
     */
    const method = "alipay.trade.wap.pay";
    /**
     * 仅支持JSON
     */
    const format = "json";
    /**
     * 请求使用的编码格式，如utf-8,gbk,gb2312等
     */
    const charset = "	utf-8";
    /**
     * 商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA，推荐使用RSA2
     */
    const sign_type = "RSA2";
    /**
     * 调用的接口版本，固定为：1.0
     */
    const version = "1.0";
    /**
     * 请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递，具体参照各产品快速接入文档
     */
    const biz_content = "";
}