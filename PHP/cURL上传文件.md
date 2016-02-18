**CURL上传文件完整篇**

**PHP5.5之前使用CURL上传文件**

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

**PHP5.5之后使用CURL上传文件**

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

**PHP发送文件流上传文件**

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

**PHP串行化(序列化)**

	PHP串行化可以把变量包括对象，转化成连续bytes数据，你可以将串行化后的变量存在一个文件里
	或在网络上传输，然后再反串行化还原为原来的数据。PHP可以成功的保存对象的属性和方法,有时
	需要一个对象在反串行化后立即执行。PHP会自动寻找__wakeup和__sleep方法。当一个对象被PHP
	串行化，PHP会调用__sleep方法(如果存在的话). 在反串行化一个对象后，PHP 会调用__wakeup
	方法. 这两个方法都不接受参数. __sleep方法必须返回一个数组，包含需要串行化的属性. PHP
	会抛弃其它属性的值。如果没有__sleep方法，PHP将保存所有属性。

	<?php
		header("Content-type: text/html; charset=UTF-8"); 
		class Person{
		private $name;
		private $sex;
		private $age;

		function __construct($name,$age,$sex){
			$this->name = $name;
			$this->age = $age;
			$this->sex = $sex;
		}

		function say(){
			echo "我的名字：".$this->name."性别为: ".$this->sex."年龄为：".$this->age;
		}
	
	　　 //在类中添加此方法，在串行化的时候自动调用并返回数组
		function __sleep(){
			//数组中的成员$name和$age将被串行化，成员$sex则将被忽略
			$arr = array("name","age");
			//使用__sleep()方法的时候必须返回一个数组
			return($arr);			  
		}
	
		//在反串行化对象时自动调用该方法，没有参数也没有返回值
		function __wakeup(){
			//在重新组织对象的时候，为新对象中的$age属性重新赋值
			$this->age = 40;	 
		}
	}
	
	$person1 = new Person("张三",20,"男");
	$person1_string = serialize($person1);
	echo $person1_string."<br />";
	
	//反串行化对象，并自动调用了__wakeup()方法重新为独享中的age赋值。
	$person2 = unserialize($person1_string);
	$person2->say();