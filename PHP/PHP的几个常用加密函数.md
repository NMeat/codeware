# PHP的几个常用加密函数 #
在网站的开发过程中，常常需要对部分数据（如用户密码）进行加密，本文主要介绍PHP的几个常见的加密函数

**MD5加密**：

    string md5 ( string $str [, bool $raw_output = false ] )

1.md5()默认情况下以 32 字符十六进制数字形式返回散列值，它接受两个参数，第一个为要加密的字符串，第二个为raw_output的布尔值，默认为false，如果设置为true，md5()则会返回原始的 16 位二进制格式报文摘要

2.md5()为单向加密，没有逆向解密算法，但是还是可以对一些常见的字符串通过收集，枚举，碰撞等方法破解

**Crypt加密**：

    string crypt ( string $str [, string $salt ] )

1.crypt()接受两个参数，第一个为需要加密的字符串，第二个为盐值（就是加密干扰值，如果没有提供，则默认由PHP自动生成）；返回散列后的字符串或一个少于 13 字符的字符串，后者为了区别盐值。

2.crypt()为单向加密，跟md5一样。

**Sha1加密：**

    string sha1 ( string $str [, bool $raw_output = false ]

1.跟md5很像，不同的是sha1()默认情况下返回40个字符的散列值，传入参数性质一样，第一个为加密的字符串，第二个为raw_output的布尔值，默认为false，如果设置为true，sha1()则会返回原始的20 位原始格式报文摘要

2.sha1()也是单行加密，没有逆向解密算法


**Urlencode加密：**

    string urlencode ( string $str )

1.一个参数，传入要加密的字符串（通常应用于对URL的加密），

2.urlencode为双向加密，可以用urldecode来加密（严格意义上来说，不算真正的加密）

3.返回字符串，此字符串中除了 -_. 之外的所有非字母数字字符都将被替换成百分号（%）后跟两位十六进制数，空格则编码为加号（+）。

**base64编码加密：**

    string base64_decode ( string $encoded_data )

1.base64_encode()接受一个参数，也就是要编码的数据（这里不说字符串，是因为很多时候base64用来编码图片）

2.base64_encode()为双向加密，可用base64_decode()来解密
