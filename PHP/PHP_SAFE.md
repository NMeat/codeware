# PHP安全配置 #
**1.禁用脚本执行shell函数**

    可以在php.ini文件中禁用某些函数
    disable_functions = 函数名(例如:system、exec、passthru、shell_exec、proc_open、popen)

    Register Globals :打开后可以注册全局变量, 本特性已自 PHP 5.3.0 起废弃并将自 PHP 5.4.0 起移除
	


**2.CSRF**

	CSRF:跨站请求伪造,跨站请求伪造(CSRF)是一种允许`攻击者`通过`受害者`发送任意HTTP请求
	的一类攻击方法。
	此处所指的受害者是一个不知情的同谋，所有的伪造请求都由他发起，而不是攻击者。
	这样，很你就很难确定哪些请求是属于跨站请求伪造攻击。
	事实上，如果没有对跨站请求伪造攻击进行特意防范的话，你的应用很有可能是有漏洞的。
	
> 你需要用几个步骤来减轻跨站请求伪造攻击的风险。一般的步骤包括使用POST方式而不是使用GET来提交表单，在处理表单提交时使用$_POST而不是$_REQUEST，同时需要在重要操作时进行验证（越是方便，风险越大，你需要求得方便与风险之间的平衡）
> 
> 通过在你的表单中包括验证码，你事实上已经消除了跨站请求伪造攻击的风险。可以在任何需要执行操作的任何表单中使用这个流程

**3.不要让不相关的人看到报错信息**

	在php.ini里设置
	display_errors = Off 
	如果你想继续看到报错可以设置log_errors = On,并在error_log选项中设置出错日志文件的保存路径

	由于出错报告的级别设定可以导致有些错误无法发现，您至少需要把error_reporting设
	为E_ALL。E_ALL | E_STRICT 是最高的设置，提供向下兼容的建议，如不建议使用的提示。

所有的出错报告级别可以在任意级别进行修改，所以您如果使用的是共享的主机，没有权限对`php.ini`, `httpd.conf`, 或 `.htaccess`等配置文件进行更改时，您可以在程序中运行出错报告级别配置语句：

    <?php
	    ini_set('error_reporting', E_ALL | E_STRICT);
	    ini_set('display_errors', 'Off');
	    ini_set('log_errors', 'On');
	    ini_set('error_log', '/usr/local/apache/logs/error_log');

`set_error_handler()` 函数
PHP还允许您通过 `set_error_handler( ) `函数指定您自已的出错处理函数：

    <?php
    	set_error_handler('my_error_handler');

上面程序指定了您自已的出错处理函数my_error_handler()。下面是一个实际使用的示例：

    <?php
	    function my_error_handler($number, $string, $file, $line, $context)
	    {
			$error = "=  ==  ==  ==  ==\nPHP ERROR\n=  ==  ==  ==  ==\n";
			$error .= "Number: [$number]\n";
			$error .= "String: [$string]\n";
			$error .= "File:   [$file]\n";
			$error .= "Line:   [$line]\n";
			$error .= "Context:\n" . print_r($context, TRUE) . "\n\n";
			error_log($error, 3, '/usr/local/apache/logs/error_log');
	    }
PHP 5还允许向set_error_handler( )传递第二个参数以限定在什么出错情况下执行出定义的出错处理函数。比如，现在建立一个处理告警级别（warning）错误的函数：

    <?php
    	set_error_handler('my_warning_handler', E_WARNING);
