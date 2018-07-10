1. pull最新的php源代码文件

   ```
   git clone https://github.com/php/php-src.git  //克隆最新的源代码
   ```

2. 配置编译参数

   ```
   buildconf 本身是个简单的shell脚本，你可以用记事本打开看看它（最终的执行文件在 build 目录里，这个目录里有一些与编译有关的文件
   ./buildconf   //生成configure配置文件
   
   ./configure \					
   --prefix=/usr/local/php73 \						[PHP7安装的根目录]
   --with-config-file-path=/usr/local/php73/etc \	[PHP7的配置目录]
   --enable-fpm \
   --enable-debug \
   
   ./configure --prefix=/usr/local/php7 --with-config-file-path=/usr/local/php7/etc --enable-fpm --enable-debug
   
   cp /usr/local/php7/bin/php /usr/local/bin/
   ```