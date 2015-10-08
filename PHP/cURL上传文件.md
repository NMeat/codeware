**CURL上传文件完整篇**

> PHP5.5之前使用CURL上传文件

    /**
     * 第一种写法，PHP版本要求<5.5
     * @$filename 是文件路径，必须有
     * filename=test.txt 是接收方收到的文件名，为空时 则取 filename 文件路径中的 
     * basename部分
     * type=text/plain 文档类型，可以为空
     */
 
    /**
     * @param string $target_url 上传目标地址
     * @param string $filename 上传文件路径
     * @param string $formname 表单名称
     */

    function curlUploadFile($target_url, $filename, $formname) {
	    $post_data = array(
	    	$formname => "@$filename;filename=test.txt;type=text/plain",
   		);
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
    $filename 	= realpath("C:/Users/HelloWorld/Desktop/Images/1.jpg");
    $formname	= 'file';
    // 接收端使用$_FILES接受
    curlUploadFile($target_url, $filename, $formname);

> PHP5.5之后使用CURL上传文件

    /*
     * 第二种写法，推荐PHP版本>=5.5中使用
     * CURLFile参数解释
     * @$filename 需要上传的文件，建议使用绝对路径
     * @$mimetype: 默认是 application/octet-stream，此处留空
     * @$postname: 接收方$_FILES数组中的文件名，默认为文件名
     */
     
    /**
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
    // 接收端使用$_FILES接受
    curlUploadFile($target_url, $filename, $formname);

> PHP发送文件流上传文件

    /*
     * 第三种写法，使用PHP流发送
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