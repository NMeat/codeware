# PHP处理密码的几种方式	 

在使用PHP开发Web应用的中，很多的应用都会要求用户注册，而注册的时候就需要我们对用户的信息进行处理了，最常见的莫过于就是邮箱和密码了，本文意在讨论对密码的处理：也就是对密码的加密处理。

**MD5**

相信很多PHP开发者在最先接触PHP的时候，处理密码的首选加密函数可能就是MD5了，我当时就是这样的：

    $password = md5($_POST["password"]);

上面这段代码是不是很熟悉？然而MD5的加密方式目前在PHP的江湖中貌似不太受欢迎了，因为它的加密算法实在是显得有点简单了，而且很多破解密码的站点都存放了很多经过MD5加密的密码字符串，所以这里我是非常不提倡还在单单使用MD5来加密用户的密码的。

**SHA256 和 SHA512**

其实跟前面的MD5同期的还有一个SHA1加密方式的，不过也是算法比较简单，所以这里就一笔带过吧。而这里即将要说到的SHA256 和 SHA512都是来自于SHA2家族的加密函数，看名字可能你就猜的出来了，这两个加密方式分别生成256和512比特长度的hash字串。

他们的使用方法如下：

    <?php
    $password = hash("sha256", $password);
    PHP内置了hash()函数，你只需要将加密方式传给hash()函数就好了。
	你可以直接指明sha256, sha512, md5, sha1等加密方式。

**盐值**

在加密的过程，我们还有一个非常常见的小伙伴：盐值。对，我们在加密的时候其实会给加密的字符串添加一个额外的字符串，以达到提高一定安全的目的：

    <?php
	    
	    function generateHashWithSalt($password) {
	    $intermediateSalt = md5(uniqid(rand(), true));
	    $salt = substr($intermediateSalt, 0, 6);
	    return hash("sha256", $password . $salt);
    }


**Bcrypt**

如果让我来建议一种加密方式的话，Bcrypt可能是我给你推荐的最低要求了，因为我会强烈推荐你后面会说到的Hashing API，不过Bcrypt也不失为一种比较不错的加密方式了。

    <?php
    function generateHash($password) {
	    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
		    $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
		    return crypt($password, $salt);
	    }
    }

Bcrypt 其实就是`Blowfish`和`crypt()`函数的结合，我们这里通过`CRYPT_BLOWFISH`判断Blowfish是否可用，然后像上面一样生成一个盐值，不过这里需要注意的是，crypt()的盐值必须以$2a$或者$2y$开头，详细资料可以参考下面的链接：

> http://www.php.net/security/crypt_blowfish.php

更多资料可以看这里：

> http://php.net/manual/en/function.crypt.php

**Password Hashing API**

这里才是我们的重头戏，Password Hashing API是PHP 5.5之后才有的新特性，它主要是提供下面几个函数供我们使用：

    password_hash() – 对密码加密.
    password_verify() – 验证已经加密的密码，检验其hash字串是否一致.
    password_needs_rehash() – 给密码重新加密.
    password_get_info() – 返回加密算法的名称和一些相关信息.

虽然说crypt()函数在使用上已足够，但是password_hash()不仅可以使我们的代码更加简短，而且还在安全方面给了我们更好的保障，所以，现在PHP的官方都是推荐这种方式来加密用户的密码，很多流行的框架比如Laravel就是用的这种加密方式。

    <?php
    	$hash = password_hash($passwod, PASSWORD_DEFAULT);

对，就是这么简单，一行代码，All done。

PASSWORD_DEFAULT目前使用的就是Bcrypt，所以在上面我会说推荐这个，不过因为Password Hashing API做得更好了，我必须郑重地想你推荐Password Hashing API。这里需要注意的是，如果你代码使用的都是PASSWORD_DEFAULT加密方式，那么在数据库的表中，password字段就得设置超过60个字符长度，你也可以使用PASSWORD_BCRYPT，这个时候，加密后字串总是60个字符长度。

这里使用password_hash()你完全可以不提供盐值(salt)和 消耗值 (cost)，你可以将后者理解为一种性能的消耗值，cost越大，加密算法越复杂，消耗的内存也就越大。当然，如果你需要指定对应的盐值和消耗值，你可以这样写：

    <?php
	    $options = [
	    'salt' => custom_function_for_salt(), //write your own code to generate a suitable salt
	    'cost' => 12 // the default cost is 10
	    ];
	    $hash = password_hash($password, PASSWORD_DEFAULT, $options);

密码加密过后，我们需要对密码进行验证，以此来判断用户输入的密码是否正确：

    <?php
	    if (password_verify($password, $hash)) {
	    // Pass
	    }
	    else {
	    // Invalid
	    }

很简单的吧，直接使用password_verify就可以对我们之前加密过的字符串（存在数据库中）进行验证了。

然而，如果有时候我们需要更改我们的加密方式，如某一天我们突然想更换一下盐值或者提高一下消耗值，我们这时候就要使用到password_needs_rehash()函数了：

    <?php
	    if (password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => 12])) {
	    // cost change to 12
	    $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
	    
	    // don't forget to store the new hash!
	    }

只有这样，PHP的Password Hashing API才会知道我们重现更换了加密方式，这样的主要目的就是为了后面的密码验证。

简单地说一下password_get_info()，这个函数一般可以看到下面三个信息：

- algo – 算法实例
- algoName – 算法名字
- options – 加密时候的可选参数
- 所以，现在就开始用PHP 5.5吧，别再纠结低版本了。

转截至：

    https://jellybool.com/post/php-password-hash-in-the-right-way