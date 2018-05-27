<?php
//批量curl请求
function multiple_threads_request($urls)
{
    $mh = curl_multi_init();
    $curl_array = array();

    foreach ($urls as $i => $url) {
        $curl_array[$i] = curl_init($url);
        curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_array[$i], CURLOPT_NOSIGNAL, 1);
        curl_setopt($curl_array[$i], CURLOPT_CONNECTTIMEOUT_MS, 300);
        curl_setopt($curl_array[$i], CURLOPT_TIMEOUT_MS, 300);
        curl_multi_add_handle($mh, $curl_array[$i]);
    }

    $running = NULL;
    do {
        usleep(10000);
        curl_multi_exec($mh, $running);
    } while ($running > 0);

    $res = array();
    foreach ($urls as $i => $url) {
        $res[$i] = curl_multi_getcontent($curl_array[$i]);
    }

    foreach ($urls as $i => $url) {
        curl_multi_remove_handle($mh, $curl_array[$i]);
    }

    curl_multi_close($mh);
    return $res;
}

//实例:通过WebService查询天气
$data = 'theCityName=北京';
$http_header = array('application/x-www-form-urlencode;charset=utf-8', 'Content-length:' . strlen($data));
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

/*
 * 第二种写法，推荐PHP版本>=5.5中使用
 * CURLFile参数解释
 * @$filename 需要上传的文件，建议使用绝对路径
 * @$mimetype: 默认是 application/octet-stream，此处留空
 * @$postname: 接收方$_FILES数组中的文件名，默认为文件名
 *
 * @param string $target_url 上传目标地址
 * @param string $filename 上传文件路径
 * @param string $formname 表单名称
 */
function curlUploadFile($target_url, $filename, $formname) {
	$upload_file = new CURLFile($filename);
	$post_data   = array($formname => $upload_file);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $target_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	// 调试信息
	// var_dump($result);
	curl_close($ch);
}

$target_url = 'http://www.codean.net/notFound/test.php';
$filename = realpath("C:/Users/HelloWorld/Desktop/Images/1.jpg");
$formname = 'file';
//接收端使用$_FILES接受
curlUploadFile($target_url, $filename, $formname);


/*
 * 使用PHP流发送
 * @param string $target_url 上传目标地址
 */
function curlUploadFile($target_url) {
	$fh = fopen('php://temp', 'rw+');
	$string = 'Hello World';
	fwrite($fh, $string);
	rewind($fh);
	$ch =  curl_init();
	curl_setopt($ch, CURLOPT_URL, $target_url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($ch, CURLOPT_PUT, true);
	curl_setopt($ch, CURLOPT_INFILE, $fh);
	curl_setopt($ch, CURLOPT_INFILESIZE, strlen($string));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	// 调试信息
	// var_dump($result);
	curl_close($ch);
}

$target_url = 'http://www.codean.net/notFound/test.php';
curlUploadFile($target_url);

// 接收端取出流文件并保存
$putdata = fopen('php://input', 'r');
$fp = fopen('test.txt', 'w');
while ($data = fread($putdata, 1024)) {
	fwrite($fp, $data);
}
fclose($fp);
fclose($putdata);



