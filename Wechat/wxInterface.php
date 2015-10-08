<?php
/**
 * 微信接口封类
 *@author   liuzhifeng
 *@date     2015-02-09
 */
class wxInterface
{
    public $appid        = "";  //开发者应用ID
    public $appsecret    = "";  //开发者应用密钥
    public $access_token = "";  //全局标识符
    
    //构造函数
    public function __construct ($appid = null ,$appsecret = null )
    {
        if($appid && $appsecret)
        {
            $this->appid     = $appid;
            $this->appsecret = $appsecret;
        }
    }

    /**
     * 获取和更新access_token值封装函数
     *@param    $host   String -  memcache服务器的地址 　　　默认值是127.0.0.1 
     *@param    $port   Int    -  memcache服务器的监听端口　 默认值是11211
     *@return           String -  返回token值
     */
    function getAccessToken($host = "127.0.0.1", $port = 11211)
    {
        //获取access_token值的接口
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
        $memObj = new Memcache;
        $memObj->connect($host, $port);
        $access_token   = $memObj->get("access_token");//获取token值
        $token_time     = $memObj->get("tokenTime");   //获取token值的生命期
        if($access_token && $token_time) //token值和token值的生命期 都存在　都获取到
        {
            $timeNow    = time();
            $remainTime = $timeNow - $token_time;              
            if(6900 < $remainTime)   //总的有效期是7200秒　如果离token的到期时间不足300秒　则更新token值
            {
                $res = $this->https_request($url);//GET 请求
                $res = json_decode($res, TRUE);   //解码json数据成数组
                $this->access_token = $res['access_token'];
                $memObj->set("access_token", $this->access_token, 0, 7200);
                $memObj->set("tokenTime" , time(), 0, 0);  //tokenTime值永远有效　用来存储token值存入的时间
            }
            else
            {
                $this->access_token = $access_token;
            }
        }
        else
        {
            $res  = $this->https_request($url);//GET请求
            $res  = json_decode($res, TRUE);
            $this->access_token = $res["access_token"];
            $memObj->set("access_token", $this->access_token, 0, 7200);
            $memObj->set("tokenTime", time(), 0, 0); //tokenTime值永远有效　用来存储token值存入的时间
        }
        $memObj->close();//关闭联接资源
   	}

    /**
     * 微信接口请求封装函数
     *@param   $url     String -  请求数据的url地址
     *@param   $data    Json   -  Json格式的数据　get请求默认为空　post请求不能为空
     *@return  $output  Json   -  返回Json格式的数据
     */
    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data))//data为空　则是post请求
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 获取用户基本信息封装函数
     *@param   $openid  int    - 用户ID标识符  
     *@return           array  - 用户基本信息数组
     */
    function getUserInfo($openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);
        return json_decode($res, TURE);
    }
    /**
     * 拉图片
     *@param   $mediaID String -微信服务器图片的ID
     *         $id      Int    -数据表的图片主键ID
     *         $path    String -图片的路径
     *@return           String -本地服务器上的原图路径
     */
    function getUserImg($mediaID,$id,$path)
    {
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->access_token."&media_id=$mediaID";//获取图片的接口
        copy($url, $path."/". $id .".jpg");//拷贝远程图像到本地
        return $path."/". $id .".jpg";//返回本地原图的路径
    }
}
