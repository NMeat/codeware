1. pull最新的php源代码文件

   ```
   从 Branch 中选择一个版本 tag，和每次 PHP 发布出来的版本就是一致的，克隆最新的源代码
   git clone https://github.com/php/php-src.git  
   ```

2. 配置编译参数

   ```
   找不到 configure 文件，但是有 configure.in 文件。这时候需要先执行的是 buildconf（如果是在 Windows 下面可以执行 buildconf.bat。
   
   生成configure配置文件  buildconf是一个shell脚本
   ./buildconf   
   
   生成Makefile文件
   
   抛开一些核心扩展额依赖（比如 xml，ssl 等），编译 PHP 的先决条件是机器上有 Autotools 的工具（automake，autoconf 等），需要安装 re2c 和 Bison，当然还有编译工具（gcc）
   
   使用 configure 生成 Makefile 的时候可以通过 --prefix 参数指定目录，同时也可以选择编译哪些核心模块。至于哪些模块会被默认集成而哪些不会，这些本身是写在每个扩展的 config.m4 （也有几个是被命名为 config0.m4 或 config9.m4）文件里的的，全都通过一些 --enable、--disable、--with 和 --without 的选项来控制。
   
   configure是一个shell脚本， ./configure -h 可以查看相应的参数说明
   
   ./configure \					
   --prefix=/usr/local/php73 \						[PHP7安装的根目录]
   --with-config-file-path=/usr/local/php73/etc \	[PHP7的配置目录]
   --enable-fpm \
   --enable-debug \
   
   ./configure --prefix=/usr/local/php7 --with-config-file-path=/usr/local/php7/etc --enable-fpm --enable-debug
   
   在 PHP 源码根中已经准备了两份配置文件的模板：php.ini-development 和 php.ini-production。显然是分别用于开发环境和生产环境的，将其中一个复制到配置文件目录并重命名为 php.ini 即可（如果你不知道配置文件的目录在哪里，可以使用 php --ini 命令查看）。然后也可以根据你的需要修改它。
   
   至于 php-fpm 的控制脚本，源码中本身也是有提供的，在 sapi/fpm 目录下。这个目录下的几个文件中有 php-fpm 配置文件的模板，也有稍微修改即可放到服务器 /etc/init.d 目录下用于控制 php-fpm 的 start、stop、restart 和 reload 动作的脚本，现在的版本中也提供了用于 systemd 的 service 文件。
   
   cp /usr/local/php7/bin/php /usr/local/bin/
   ```

3. 扩展安装

   如果 PHP 编译完成之后，发现还需要一些没有编译进去的核心扩展或者第三方扩展，你可以单独编译它们。

   ```
   phpize 命令是用来准备 PHP 扩展库的编译环境的。在执行 phpize 的时候，如果有多个版本的 PHP，用哪个就要选哪个。这个命令和编译后的 php 的二进制文件在同一个目录中，也是一个 shell 脚本
   phpize
   
   phpize 命令是用来准备 PHP 扩展库的编译环境的。在执行 phpize 的时候，如果有多个版本的 PHP，用哪个就要选哪个。这个命令和编译后的 php 的二进制文件在同一个目录中，也是一个 shell 脚本。
   ./configure
   
   make
   make install
   
   phpize 和 php-config 的源码生成文件都是在 scripts 目录下。
   ```

   

   

    