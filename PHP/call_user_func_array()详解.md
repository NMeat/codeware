**PHP函数call_user_func_array()详解**

    /**
     * call_user_func_array():调用一个回调函数，并将一个数组作为回调函数的参数
     * call_user_func_array($callback, array $param_arr)函数详解
     * @param $callback:被调用的回调函数
     * @param array $param_arr:作为参数的数组
     * 注意：第二个参数数组长度必须 == 回调函数参数个数
     */
     
    // code...
     
    function foo($num, $num2, $num3) {
	    var_dump($num);
	    var_dump($num2);
	    var_dump($num3);
    }
     
    // 回调函数为普通函数
    call_user_func_array('foo', array('aa' => '1', '2', '3'));
    // 结果：
    // string '1' (length=1)
    // string '2' (length=1)
    // string '3' (length=1)
     
    class Mary {
	    public function sayName($name) {
	    	var_dump('My name is ' . $name);
	    }
    }
     
    class Jack {
	    public function talk($name, $city) {
	    	var_dump('My name is ' . $name . ". I'm from " . $city);
	    }
    }
     
    /**
     * 注意：如果回调函数为某个类的方法，则第一个参数必须为数组；
     *   数组中含有两个元素：第一个为类名，第二个为方法名；
     *   在PHP版本5.3.0之前，第二个参数会被默认为静态方法
     *如果方法不是静态方法，则需先将类实例化,否则会发出一个E_STRICT警告;
     */
     
    // 回调函数为类方法
    call_user_func_array(array('Mary', 'sayName'), array('Mary'));
    call_user_func_array(array('Jack', 'talk'), array('Jack', 'NewYork'));
    // 结果：
    // string 'My name is Mary' (length=15)
    // string 'My name is Jack. I'm from NewYork' (length=33)
     
     
    // 回调函数为函数体
    call_user_func_array(function($text) {var_dump($text);}, array('Hello World'));
    // 也可以将函数体赋值给一个变量
    $func = function($num, $num2) {
    	return $num * $num2;
    };
    $num = call_user_func_array($func, array(10, 10));
    var_dump($num);
    // 结果：
    // int 100