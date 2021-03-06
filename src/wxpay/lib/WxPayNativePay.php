<?php
/**
 * 刷卡支付实现类
 */
namespace EasyPayment\payment\wxpay\lib;

use EasyPayment\payment\wxpay\lib\WxPayApi;

class WxPayNativePay
{

    /**
     * 生成扫描支付URL,模式一
     * @param $productId
     * @return string
     * @throws WxPayException
     */
    public function GetPrePayUrl($productId)
    {
        $biz = new WxPayBizPayUrl();
        $biz->SetProduct_id($productId);
        $values = WxPayApi::bizpayurl($biz);
        $url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
        return $url;
    }

    /**
     * 参数数组转换为url参数
     * @param array $urlObj
     * @return string
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 生成直接支付url，支付url有效期为2小时,模式二
     *
     * @param WxPayUnifiedOrder $input
     * @return mixed
     * @throws WxPayException
     */
    public function GetPayUrl($input)
    {
        if ($input->GetTrade_type() == "NATIVE") {
            $result = WxPayApi::unifiedOrder($input);
            return $result;
        }
        return false;
    }
}