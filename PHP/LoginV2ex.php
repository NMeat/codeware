<?php
/**
* 
*  登陆v2ex
*
*/
class LoginV2ex{
	private $userName;	//用户名
	private $password;  //用户密码
	private $cookie;    //网站cookie
	private $html;		
	private $once;      //登陆表单隐藏域名的值
    

    //登录页面 取cookie once
    private static $loginPageAPI = 'http://www.v2ex.com/signin';
    //登录POST表单地址
    private static $loginAPI     = 'http://www.v2ex.com/signin';
    //签到页面 取once
    private static $signinPage   = 'http://www.v2ex.com/signin';
	//提交签到地址
	private static $signinAPI    = 'http://www.v2ex.com/mission/daily/redeem?once=';

	//请求头
	private static $header = array(
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Content-Type: application/x-www-form-urlencoded',
        'Referer: http://www.v2ex.com/signin',
        'Origin: http://www.v2ex.com'
	);

	private static $optionsCommon = array(
        CURLOPT_AUTOREFERER => 1, 		//当根据Location:重定向时，自动设置header中的Referer:信息
        CURLOPT_FOLLOWLOCATION => 1, 	//将服务器服务器返回的"Location: "放在header中递归的返回给服务器
        CURLOPT_HEADER => 1, 			//将头文件的信息作为数据流输出
        CURLOPT_RETURNTRANSFER => 1     //将curl_exec() 获取的信息以文件流的形式返回，而不是直接输出。
    );


	public function login($userName, $password){
		$this->userName = $userName;
        $this->password = $password;
        //第一次请求登陆页面，为了获取cookie和once
        $this->get(self::$loginPageAPI, null);
        // file_put_contents('aa', $this->html);
        //获取登陆参数：cookie
        $this->getCookie($this->html);
        //获取登陆参数：once
        $this->getOnce($this->html);
        //提交用户名和密码
        $this->post(
        	self::$loginAPI,
        	array(
        		'u'=>$this->userName,
        		'p'=>$this->password,
        		'once'=>$this->once,
        		'next'=>'/'
        	),
        	self::$optionsCommon
        );
        file_put_contents("v2ex.html", $this->html);
        echo "执行成功!\n";
	}

	//登录提交表单
	public function post($url, $field = array()){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header);
		curl_setopt_array($ch, self::$optionsCommon);
		curl_setopt($ch, CURLOPT_POST, 1);	//设置为post请求
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($field));
		curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');	//指定cookie文件的路径
		$this->html = curl_exec($ch);
		curl_close($ch); //关闭资源
		if ($this->html === false) {
			exit("POST失败");
		}

		return $this->html;
	}

	//签到
    public function signin()
    {
        $this->get(self::$API_SIGNINPAGE, $this->cookie);
        $this->getCookie($this->html);
        $this->getOnce($this->html);
        $siginURL = self::$API_SIGNIN . $this->once;
        //签到
        $this->get($siginURL, $this->cookie);
        echo $this->html;
    }

	//获取登录页内容
	public function get($url, $cookie){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header); //设置请求头
		curl_setopt_array($ch, self::$optionsCommon);		 //设置参数
		if ($cookie !== null) {
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);		 //设置cookie
		}
		$this->html = curl_exec($ch);
		curl_close($ch);	//关闭资源
		if($this->html === false){
			exit("GET请求失败!\n");
		}
		return $this->html;
	}

	//正则取cookie
    private function getCookie($html)
    {
        if (preg_match_all("/set\-cookie:([^\r\n]*)/i", $html, $matches)) {
            foreach ($matches[1] as $value) {
                $this->cookie .= $value;
            }
            file_put_contents("cookie.txt", $this->cookie);
        }
        return $this->cookie;
    }

    /**
     * 获取登陆页面和签到
     * 页面中的校验码once
     */
    private function getOnce($html)
    {
        if (preg_match("/value=\"(\d+).*once/", $html, $matches)) {
        } elseif (preg_match("/once=(\d+)/", $html, $matches)) {
        } else {
            exit("获取once失败");
        }
        $this->once = $matches[1];
        file_put_contents("once.txt", $this->once);
        return $this->once;
    }
}

$lg = new LoginV2ex();
$lg->login('laucie', 'laucie5178');


