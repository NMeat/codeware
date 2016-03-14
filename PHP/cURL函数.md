**CURL函数**

    /**
     * CURL:Client URL Library Functions
     * 概念:curl is a command line tool for transferring data width URL syntax
     * 使用URL语法传输数据的的命令行工具
     * 使用场景：
     * 1.网页资源
     * 2.WebService数据接口资源
     * 3.FTP服务器里面的文件资源
     * 4.其他资源
     */
     
    实例1：抓取百度首页面
	    $curl = curl_init('http://www.baidu.com');
	    curl_exec($curl);
	    curl_close($curl);
     
    实例2：抓取百度首页面内容并替换部分字符
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://www.baidu.com');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);	  // 不直接打印
    $output = curl_exec($curl);
    curl_close($curl);
    echo str_replace('百度', '谷歌哈哈', $output);
    // 刷新页面，会发现输出的静态页面中的百度都被换成了谷歌哈哈
	//(要将上面第一个实例的代码隐藏或更换URL)
     
    实例3：通过WebService查询天气
    $data = 'theCityName=北京';
    $http_header = array(
			'application/x-www-form-urlencode;charset=utf-8', 
			'Content-length:' . strlen($data)
		);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://www.webxml.com.cn/WebServices/WeatherWebService.asmx/getWeatherbyCityName');
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
    	echo 'curl error:' . curl_error($curl);
    } else {
    	var_dump($result);
    }
    curl_close($curl);
