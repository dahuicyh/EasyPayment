# EasyPayment（Third party payment class library,Contain alipay, wxpay, bdpay）

[![Latest Stable Version](https://poser.pugx.org/zwxhenu/easy-payment/v/stable)](https://packagist.org/packages/zwxhenu/easy-payment)
[![Total Downloads](https://poser.pugx.org/zwxhenu/easy-payment/downloads)](https://packagist.org/packages/zwxhenu/easy-payment)
[![Latest Unstable Version](https://poser.pugx.org/zwxhenu/easy-payment/v/unstable)](https://packagist.org/packages/zwxhenu/easy-payment)
[![License](https://poser.pugx.org/zwxhenu/easy-payment/license)](https://packagist.org/packages/zwxhenu/easy-payment)

### 参考文档[支付文档]
<a href="https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_1">微信支付SDK</a><br/><a href="https://opendocs.alipay.com/open/62/104743/">支付宝支付SDK</a><br/><a href="https://b.baifubao.com/static/spcenter/fe-wallet-open-platform/entry/develop-document/#/document?mdUrl=5bd00a26557d0a2f834cd231">百度钱包SDK</a></p>

# 环境要求
- php版本:>=5.6
- laravel版本: Laravel5.5+

# 安装
```php
composer require zwxhenu/easy-payment

```
# 当前支持功能

## 微信支付
   - JSAPI支付
   - Native支付
   - 支付查询
   - 金额退款
   - 退款结果查询
## 支付宝
   - 网页版支付
   - 支付查询
   - 即时有密退款
## 百度钱包 
   - 网页版支付
   - 支付查询
   - 退款
   - 查询退款结果
   
# 使用示例

## 支付宝示例

```php
use EasyPayment\payment\alipayService;

/*********支付宝*************/

$pay = new AlipayService();
#-----公共参数配置------#
$pay->setPartner(''); //合作商户
$pay->setInputCharset('utf-8'); // 参数编码字符集 默认utf-8
$pay->setSignType('MD5'); // 签名方式默认 MD5
$pay->setNotifyUrl(''); // 服务器异步通知页面路径
#-----公共参数配置结束-----#

$pay->setSellerId(''); // 卖家支付宝用户号
$pay->setOrderSn('13354666'); // 商户网站唯一订单号
$pay->setPayMoney('0.01'); // 交易金额
$pay->setSubject('֧测试支付'); //商品名称
$pay->setBody('֧测试支付'); // 商品描述
$pay->setReturnUrl('http://www.baidu.com'); // 页面跳转同步通知页面路径
$pay->setTradeType(1); // 支付类型
$res = $pay->directPay();

/*******支付宝查询******/
$trade_no = '';
$out_trade_no = '';
$pay->setKey('');// 合作商户支付秘钥
$pay->setSellerId('');// 合作商户ID
$pay->setPartner('');// 合作商户
$pay->setOutTradeNo('');// 支付宝交易流水号
$pay->setOrderSn('');// 商户网站订单系统中唯一订单号
// $trade_no 支付宝交易流水号 $out_trade_no 商户网站订单系统中唯一订单号，必填
$query_res = $pay->queryOrder();

/*******支付宝即时退款*****/
$pay->setSellerEmail('');// 卖家支付宝账号
$pay->setSellerId('');// 卖家用户ID
$pay->setBatchOn('');// 退款批次号 格式为：退款日期（8位）+流水号（3～24位）。
$pay->setBatchNum(1);// 总笔数 最大支持1000笔
$pay->setDetailData(''); // 单笔数据集 例如：2014040311001004370000361525^5.00^协商退款
$refund_res = $pay->fastPayRefundByPlatformPwd();

```

## 微信支付示例

```php
use EasyPayment\payment\WxPayService;
/**************微信二维码支付************/
/**
 * 微信公众号信息配置
 * APPID：绑定支付的APPID（必须配置）
 * MCHID：商户号（必须配置）
 * KEY：商户支付密钥，参考开户邮件设置（必须配置）
 * APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置）
 **/
$wx_pay = new WxPayService();
#--------公共配置--------#
// 商户号（必须配置）
$wx_pay->setMchId('');
// 公众帐号secert（仅JSAPI支付的时候需要配置）
$wx_pay->setAppSecret('');
// 绑定支付的APPID
$wx_pay->setAppId('');
// KEY：商户支付密钥，参考开户邮件设置（必须配置）
$wx_pay->setKey('');
#--------公共配置结束--------#

$wx_pay->setOrderSn('12345689');
$wx_pay->setOutOrderNo('4567891');
$wx_pay->setPayMoney(0.01);
$wx_pay->setSubject('测试二维码支付');
$wx_pay->setBody('测试二维码支付');
$wx_pay->setSuccessUrl('http://www.baidu.com');
$wx_pay->setErrorUrl('http://www.baidu.com');
$wx_pay->setTradeType(1);
$res = $wx_pay->nativePay();
$qrcode = $res['data'];
echo $_SERVER['HTTP_HOST'].'/'.$qrcode;

/**************微信支付************/

$wx_pay->setIsWap(true);
$wx_pay->setOrderSn('123456789');
$wx_pay->setPayMoney(0.01);
$wx_pay->setSubject('测试微信支付');
$wx_pay->setBody('测试微信支付');
$wx_pay->setSuccessUrl('http://www.baidu.com');
$wx_pay->setErrorUrl('http://www.baidu.com');
$res = $wx_pay->jsAPIPay('454645'); // 微信的openid

/*************微信支付查询*************/

$wx_pay->setWxOrderId(''); //微信交易流水号
$wx_pay->setOutOrderNo(''); // 商户网站订单系统中唯一订单号，必填
$wx_pay_query_res = $wx_pay->queryOrder();

/*******微信支付退款***/
$wx_pay->setWxOrderId(''); //微信交易流水号
$wx_pay->setOutOrderNo(''); // 商户网站订单系统中唯一订单号，必填
$wx_pay->setOutRefundNo(''); // 商户定义的退款订单编号
$wx_pay->setTotalFee(); // 标价金额
$wx_pay->setRefundFee(); // 退款金额
$wx_pay->setRefundDesc(); // 退款原因
$wx_pay->setRefundAccount(); // 退款资金来源
$wx_pay->setNotifyUrl(); // 退款结果通知url
$wx_pay->refund();

/*********微信退款结果查询*******/

$wx_pay->setWxOrderId(''); //微信交易流水号
$wx_pay->setOutOrderNo(''); // 商户网站订单系统中唯一订单号，必填
$wx_pay->setOutRefundNo(''); // 商户定义的退款订单编号
$wx_pay->setRefundId(''); // 微信退款订单号
###以上四选一就可以查询####
$wx_pay->refundQuery();

```

## 百度钱包示例

```php

use EasyPayment\payment\BdpayService;
/**************百度钱包************/
$bd_pay = new BdpayService();
$bd_pay->setSpNo('9000100005'); // 合作商户ID
$bd_pay->setSpKey('pSAw3bzfMKYAXML53dgQ3R4LsKp758Ss'); // 合作支付秘钥
$bd_pay->setOrderSn('123456789');
$bd_pay->setPayMoney('0.01');
$bd_pay->setSubject('֧测试支付');
$bd_pay->setBody('֧测试支付');
$bd_pay->setSuccessUrl('http://www.baidu.com');
$bd_pay->setErrorUrl('http://auto.news18a.com');
$bd_pay->setTradeType(1);
$res = $bd_pay->directPay();


/**********百度钱包支付查询***********/
$bd_query_pay = new BdpayService();
$bd_query_pay->setSpNo('9000100005');// 合作商户ID
$bd_query_pay->setSpKey('pSAw3bzfMKYAXML53dgQ3R4LsKp758Ss');// 合作商户的支付秘钥
// $out_trade_no 商户网站订单系统中唯一订单号，必填
$bd_query_res = $bd_query_pay->queryOrder($out_trade_no);


/**************百度钱包发起退款****************/
$bd_refund_pay = new BdpayService();
$bd_refund_pay->setSpNo('9000100005');// 合作商户ID
$bd_refund_pay->setSpKey('pSAw3bzfMKYAXML53dgQ3R4LsKp758Ss');// 合作商户的支付秘钥
$bd_refund_pay->setSuccessUrl('www.baidu.com');
$bd_refund_pay->setErrorUrl('www.baidu.com');
$bd_refund_pay->setRefundType(2);// 退款类型 1 退回钱包余额 2 原路退回
$bd_refund_pay->setCashBackAmount(0.01); //退款金额
$bd_refund_pay->setCashBackTime(date('YmdHis')); // 退款请求时间
$order_sn = date("YmdHis"). sprintf ( '%06d', rand(0, 999999));
$bd_refund_pay->setOrderSn($order_sn);// 商户退款流水号
$refund_res = $bd_refund_pay->orderRefund();

/**************百度钱包查询退款结果***************/
$bd_query_refund_pay = new BdpayService();
$bd_query_refund_pay->setSpNo('9000100005');
$bd_query_refund_pay->setOrderSn('20140814173437256936'); // 百度钱包订单号
$bd_query_refund_pay->setOutTradeNo('2014081417354462'); // 百度钱包退款流水号
// 根据商户交易流水号查询
$order_sn_query_res = $bd_query_refund_pay->queryRefundByOrderOn();
// 根据退款流水号查询
$out_trade_no_res = $bd_query_refund_pay->queryRefundBySpRefundOn();

```