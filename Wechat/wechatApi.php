<?php
/**
 *微信接口请求验证类
 *@author:   liuzhifeng
 *@date  :   2015-02-05
 */
class wechatApi
{
    /**
     *@param   $echoStr String -随机字符串
     *@return  $echoStr String -返回随机字符串
     */
    public function valid($echoStr)
    {
        if($this->checkSignature())
        {
            echo $echoStr;//原路返回验证的随机字符串
            exit;
        }
    }
    /**
     * 校验signature
     *@param   String   -$signature 微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数
     *         String   -$timestamp  时间戳
     *         String   -$nonce      随机数
     *@return  Boolean  -true/false  
     */
   private function checkSignature()
   {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = TOKEN;//前面定义的常量
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr);//将数组进行字典序排序
        $tmpStr    = implode( $tmpArr );
        $tmpStr    = sha1( $tmpStr );
        if($tmpStr == $signature)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     *@param  $fromUsername  String -要发送的对象
     *        $toUsername    String -发送方的账号　即公众号
     *        $time          String -发送时间
     *        $msgType       String -消息类型 默认是text类型
     *        $contentStr    String -回复内容
     *@return $result        String -XML格式的内容 
     */
    public function responseMsg($fromUsername, $toUsername, $time, $msgType="text", $contentStr)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);//组织XML格式的回复内容
        echo $resultStr;
    }
}
