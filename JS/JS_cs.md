**让a标签失去跳转效果**

		    <a href="#" onclick="return false;">link1</a>
		    <a href="javascript:void(0);">link2</a>

**JS中函数的声明方法**

		    JS中函数是引用数据类型
		    //普通函数:
		    function square(x){
		   		return x*x;
		    }
		    console.log(square(3));
		    
		    //var 声明的匿名函数 又称函数表达式
		    var fnOne = function (x){
		    	return x * x;
		    };
		    
		    console.log(fnOne(3));
		
		    //或则
		    var fnTwo = (function (x){
		    	return x * x;
		    });
		    
		    console.log(fnTwo(3));
		    
		    //或则
		    (function (x) {
		    	console.log(x * x);
		    	return x * x;
		    })(3);
		    
		    //或则
		    (function fnFour (x) {
		    	console.log(x * x);
		    	return x * x;
		    }(3));


**阿里的一道面试题**

    var sum = function () {
    	return [].slice.call(arguments).map(function(x){
    				return isNaN(Number(x)) ? 0 : Number(x);
    			}).reduce(function(a,b){
    				return a + b;
    			});
  		  };
    console.log(sum(444,111));							// = 555
    console.log(sum(5, 'abc', -5));  					 // = 0
    console.log(sum(1, true, 'a', 'D', 1, 'F', 1, 'w'));  // = 4



**setTimeout**

每次循环会调用setTimeout函数，其中指定了一个timeout后执行的函数
这个函数因为构成闭包的关系，其能够访问外层函数定义的变量，这个变量就是i
在for循环执行完毕后,i的值为10.此时在事件队列中有10个timeout函数等待执行
当timeout时间到时，对应的执行函数调用的i都是同一个，也就是10

    for(var i = 0; i < 10; i++) {
	    setTimeout(function() {
	    	console.log(i);  
	    }, 1000);
    }

在for循环中定义了匿名立即执行函数
通过将每次循环时产生i传入匿名立即执行函数,立即执行函数就有了一个内部变量e，
其值是传入的i
setTimeout函数形成闭包，能访问到其外层函数也就是匿名立即执行函数的变量e
因为e引用关系的存在，匿名立即执行函数不会被马上销毁掉
timeout时间一到，指定执行函数调用的e就是每次传入的参数i

    for(var i = 0; i < 10; i++) {
	    (function(e) {
		    setTimeout(function() {
		    	console.log(e);  
	    	}, 1000);
	    })(i);
    }


整个和上面的类似,只不过把匿名立即执行函数传递给setTimeout的第1个参数中
匿名立即执行函数，顾名思义就是需要立即执行的呀。
所以setTimout函数对应的超时执行函数(第1个参数)
为匿名立即执行函数执行的结果，也就是返回的函数。
接下来理解就和上面一样啦

    for(var i = 0; i < 10; i++) {
	    setTimeout((function(e) {
	    return function() {
	    	console.log(e);
	    }
	    })(i), 1000)
    }


**检测用户是否关闭浏览器**

    window.onbeforeunload = function() {
			return '您确定要离开吗?';
	};

**JS数据类型**

	5种原始基本数据类型:数字，字符串，布尔值，null，undefined
	1种复合数据类型:对象

    JS中的数据对象是一种复合值，将很多值聚合在一起，可以通过属性访问这些值。属性名是
	包含空字符串在内的任意数据类型。

    JS中对象分为3类:
    	1、内置对角 例如数组、函数、日期等
		2、宿主对象，即JavaScript解释器所嵌入的宿主环境（比如浏览器）定义的，例如HTMLElement等；
		3、自定义对象，即程序员用代码定义的；

	   对象的属性可以分为两类：
    　　1、自有属性（own property）：直接在对象中定义的属性；
    　　2、继承属性（inherited property）：在对象的原型对象中定义的属性；
    创建对象的方法:
       1、对象直接量
		  对象直接量由若干名/值对组成的映射表，名/值对中间用冒号分隔，名/值对之间用逗号分
		  隔，整个映射表用花括号括起来。属性名可以是JavaScript标识符也可以是字符串直接
		  量，也就是说下面两种创建对象obj的写法是完全一样的：
		  var obj = {x: 1, y: 2};
		  var obj = {'x': 1, 'y':2};
	   2、通过new创建对象
    	  new运算符后跟随一个函数调用，即构造函数，创建并初始化一个新对象。例如：
	      var o = new Object();//创建一个空对象，和{}一样
	      var a = new Array(); //创建一个空数组，和[]一样
	      var d = new Date();  //创建一个表示当前时间的Date对象
	   3、Object.create()
	     ECMAScript5定义了一个名为Object.create()的方法，它创建一个新对象，其中第一个参
		 数是这个对象的原型对象。
		 这个方法使用很简单：
		 var o1 = Object.create({x: 1, y: 2});    //对象o1继承了属性x和y
		 var o2 = Object.create(null);    		  //对象o2没有原型
**Json字符串和Json对象**

    var JsonStr = '{"name":'superMan', "age":25}';//Json字符串
    var JosnObj = {		//Json对象
    		name:'superMan',
    		age:25
    	};
    将Json字符串转化成Json对象有两种方法:
    var JsonStrToObj = eval('(' + JsonStr + ')');
    或则
    var JsonStrToObj = JSON.parse(JsonStr);