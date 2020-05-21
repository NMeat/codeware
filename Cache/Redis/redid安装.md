## Redis安装配置

### 步骤如下


1. 在VPS上安装编译工具，如果已安装请忽略

        sudo yum install -y gcc gcc-c++ make jemalloc-devel epel-release

2. 在官网下载源码包
  
        wget http://download.redis.io/releases/redis-4.0.2.tar.gz
3. 解压安装
  
        sudo mkdir /usr/redis
        sudo tar -zxvf redis-4.0.2.tar.gz -C /usr/redis
        cd /usr/redis/redis-4.0.2/
        sudo make & sudo make install
        cd /usr/redis/redis-4.0.2/src/
        /usr/redis/redis-4.0.2/src/redis-server

