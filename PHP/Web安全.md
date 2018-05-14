### Web访问安全

#### 防止站外提交

1、每次打开提交页生成一个token保存在session中,提交表单时校对token和session值是否一致,一致才可以提交

2、增加验证码。表单提交时候增加验证码，可以有效防止灌水机提交数据

3、验证 $_SERVER['HTTP_REFERER']，从而判断请求是否来自自己的服务器

4、可使用JS标识表单已提交，或设置提交按钮不可用

#### 重复提交/双击提交

1、可使用JS标识表单已提交，或设置提交按钮不可用

2、可将表单处理后的转发改为重定向，当重定向到成功页面，再次刷新仍为成功页面，而不会产生重复提交，主要避免F5重复提交

#### **SQL注入**

SQL注入是WEB攻击中最常见的注入方式。也是我们这次被攻击中最多的。

由于我们的程序中大部分都是进行拼装SQL的方式，然后对于用户输入的参数也没有进行过滤，导致给攻击者留下了漏洞。

预防措施:

1、永远不要使用超级用户或所有者帐号去连接数据库。要用权限被严格限制的帐号。

2、检查输入的数据是否具有所期望的数据格式。PHP 有很多可以用于检查输入的函数，从简单的变量函数和字符			   类型函数（比如 is_numeric()，ctype_digit()）到复杂的 Perl 兼容正则表达式函数都可以完成这个工作。

3、如果程序等待输入一个数字，可以考虑使用 is_numeric() 来检查，或者直接使用 settype() 来转换它的类型，也可以用 sprintf() 把它格式化为数字。还可以使用PHP的Filter扩展，这个扩展定义了常见输入格式的过滤器，通过调用`filter_var`函数可以轻松地实现对于用户输入的过滤。

4、使用高于5.5的PHP进行数据库操作时，强烈推荐使用PDO方式连接数据库。

**XSS攻击**

xss表示Cross Site Scripting(跨站脚本攻击)，它与SQL注入攻击类似，SQL注入攻击中以SQL语句作为用户输入，从而达到查询/修改/删除数据的目的，而在xss攻击中，通过插入恶意脚本，实现对用户游览器的控制。

xss攻击可以分成两种类型：非持久型攻击和持久型攻击。

非持久型攻击：

顾名思义，非持久型xss攻击是一次性的，仅对当次的页面访问产生影响。非持久型xss攻击要求用户访问一个被攻击者篡改后的链接，用户访问该链接时，被植入的攻击脚本被用户游览器执行，从而达到攻击目的。

假设有以下index.php页面：

```PHP
<?php
$name = $_GET['name'];
echo "Welcome $name<br>";
echo "<a href="http://blog.it985.com/download/">Click to Download</a>";
```

该页面显示两行信息：

```
从URI获取 ‘name’ 参数，并在页面显示
显示跳转到一条URL的链接
```

这时，当攻击者给出以下URL链接：

```html
index.php?name=guest<script>alert('attacked')</script>
```

当用户点击该链接时，将产生以下html代码，带’attacked’的告警提示框弹出：

```html
Welcome guest
<script>alert('attacked')</script>
<br>
<a href='http://blog.it985.com/download/'>Click to Download</a>
```

除了插入alert代码，攻击者还可以通过以下URL实现修改链接的目的：

```html
index.php?name=
<script>
	window.onload = function() {
	var link=document.getElementsByTagName("a");link[0].href="http://attacker-site.com/";}
</script>
```

当用户点击以上攻击者提供的URL时，index.php页面被植入脚本，页面源码如下：

```html
Welcome 
<script>
window.onload = function() {
var link=document.getElementsByTagName("a");link[0].href="http://attacker-site.com/";}
</script>
<br>
<a href='http://blog.it985.com/download/'>Click to Download</a>
```

用户再点击 “Click to Download” 时，将跳转至攻击者提供的链接。

对于用于攻击的URL，攻击者一般不会直接使用以上可读形式，而是将其转换成ASCII码，以下URL同样用于实现链接地址变更：

```
index.php?name=%3c%73%63%72%69%70%74%3e%77%69%6e%64%6f%77%2e%6f%6e%6c%6f%61%64%20%3d%20%66%75%6e%63%74%69%6f%6e%28%29%20%7b%76%61%72%20%6c%69%6e%6b%3d%64%6f%63%75%6d%65%6e%74%2e%67%65%74%45%6c%65%6d%65%6e%74%73%42%79%54%61%67%4e%61%6d%65%28%22%61%22%29%3b%6c%69%6e%6b%5b%30%5d%2e%68%72%65%66%3d%22%68%74%74%70%3a%2f%2f%61%74%74%61%63%6b%65%72%2d%73%69%74%65%2e%63%6f%6d%2f%22%3b%7d%3c%2f%73%63%72%69%70%74%3e	
```

持久型xss攻击:

持久型xss攻击会把攻击者的数据存储在服务器端，攻击行为将伴随着攻击数据一直存在。下面来看一个利用持久型xss攻击获取session id的实例。

#### **XSS漏洞修复**

原则：　不相信客户输入的数据
注意:  攻击代码不一定在<script></script>中

1. 将重要的cookie标记为http only,   这样的话Javascript 中的document.cookie语句就不能获取到cookie了.
2. 只允许用户输入我们期望的数据。 例如：　年龄的textbox中，只允许
3. 用户输入数字。 而数字之外的字符都过滤掉。
4. 对数据进行Html Encode 处理
5. 过滤或移除特殊的Html标签， 例如: <script>, <iframe> ,  &lt; for <, &gt; for >, &quot for
6. 过滤JavaScript 事件的标签。例如 “onclick=”, “onfocus” 等等。

#### CSRF

CSRF（Cross-site request forgery）跨站请求伪造，由于目标站无token/referer限制，导致攻击者可以用户的身份完成操作达到各种目的。根据HTTP请求方式，CSRF利用方式可分为两种。CSRF攻击是源于WEB的隐式身份验证机制！WEB的身份验证机制虽然可以保证一个请求是来自于某个用户的浏览器，但却无法保证该请求是用户批准发送的！

 1、在表单中加入一个cookie的Hash值

```html
$value="someValueHere";
setcookie("cookie",$value,time()+3600);
<input type="hidden" name="hash" value="<?php echo md5($_COOKIE('cookie'));" />
```

服务端的验证:

```
$hash=md5($_COOKIE('cookie'));
if($hash==$_POST['hash']){
    //验证通过
}else{
    //验证不通过
}
```

2、验证码

在表单域中加入验证码可以杜绝csrf攻击的可能 但是这个对于用户体验并不是那么好。

3、加入一个csrf token

```html
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['STOKEN_NAME'];?>">
$pToken = "";
if($_SESSION[STOKEN_NAME]  == $pToken){
    //没有值，赋新值
    $_SESSION[STOKEN_NAME] = gen_token();
}    
else{
    //继续使用旧的值
}

function gen_token() {
    //这里我是贪方便，实际上单使用Rand()得出的随机数作为令牌，也是不安全的。
    //这个可以参考我写的Findbugs笔记中的《Random object created and used only once》
    $token = md5(uniqid(rand(), true));
    return $token;
}

```

 最后对token进行验证:

```html
$token=$_POST['csrf_token'];
if($token==$_SESSION('STOKEN_NAME')){
    //验证通过
}else{
    //验证不通过
}
```