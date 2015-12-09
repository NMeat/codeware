<?php
    /**
     *@param    $host   String-  memcache服务器的地址 　　　默认值是127.0.0.1 
     *@param    $port   int   -  memcache服务器的监听端口　 默认值是11211
     *
     *@return   String        -  返回token值
     */
    function getAccessToken($host = "127.0.0.1", $port = 11211)
    {
        $memObj = new Memcache;
        $memObj->connect($host, $port);
        $access_token   = $memObj->get("access_token");//获取token值
        $token_time     = $memObj->get("tokenTime"); //获取token值的生命期
        if($access_token && $token_time) //token值和token值的生命期　都没有过期
        {
            $timeNow    = time();
            $remainTime = $token_time - $timeNow;              
            if($remainTime < 300)   //如果离token的到期时间不足300秒　则更新token值
            {
                $access_token = "110";
            }
        }
        else   //两者任一不存在 则重新token
        {
            $access_token = "110";
        }
        $memObj->close();//关闭联接资源
        return $access_token;
   }
    $value = getAccessToken();
    var_dump($value);

    
