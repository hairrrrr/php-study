

### 一 环境安装

#### 1. Apache 

##### 安装过程 

安装教程：https://www.php.net/manual/zh/install.unix.apache2.php

Apache 默认安装在 `/usr/local/apache2`，可以使用如下命令启动和停止服务：

```shell
root@VM-4-14-ubuntu:~/php/php-8.3.6# /usr/local/apache2/bin/apachectl start
root@VM-4-14-ubuntu:~/php/php-8.3.6# ps -ef | grep "apache"
root      111782       1  0 02:18 ?        00:00:00 /usr/local/apache2/bin/httpd -k start
daemon    111783  111782  0 02:18 ?        00:00:00 /usr/local/apache2/bin/httpd -k start
daemon    111784  111782  0 02:18 ?        00:00:00 /usr/local/apache2/bin/httpd -k start
daemon    111785  111782  0 02:18 ?        00:00:00 /usr/local/apache2/bin/httpd -k start
root      111903    2153  0 02:18 pts/0    00:00:00 grep --color=auto apache
root@VM-4-14-ubuntu:~/php/php-8.3.6# /usr/local/apache2/bin/apachectl stop
```



##### `httpd.conf`

1. `DocumentRoot`：默认网页位置
2. `ServerName`：指定 IP 地址和端口（端口可以不在此处指定）
3. `Listen`：监听端口



##### 安装中可能遇到的问题

1）**`/usr/local/apache2/bin/apachectl start` 报错：端口被使用**

报错如下：

```shell
root@VM-4-14-ubuntu:~/php/php-8.3.6# /usr/local/apache2/bin/apachectl start
(98)Address already in use: AH00072: make_sock: could not bind to address [::]:80
(98)Address already in use: AH00072: make_sock: could not bind to address 0.0.0.0:80
no listening sockets available, shutting down
AH00015: Unable to open logs
```

查看占用 80 端口的进程：

```shell
root@VM-4-14-ubuntu:~/php/php-8.3.6# netstat -antp | grep 80
tcp        0      0 0.0.0.0:80              0.0.0.0:*               LISTEN      949/nginx: master p 
tcp6       0      0 :::80                   :::*                    LISTEN      949/nginx: master p    
```

`nginx` 和 `apace` 都是基于 `HTTP` 的 `web` 服务器，而 80 端口是 HTTP 的默认占用端口之一，停止 `nginx` 服务即可：

```shell
root@VM-4-14-ubuntu:~/php/php-8.3.6# systemctl stop nginx
```



#### 2. PHP

##### 安装过程

安装教程：https://www.php.net/manual/zh/install.unix.apache2.php

下载地址：https://www.php.net/downloads

```shell
cd ../php-NN
./configure --with-apxs2=/usr/local/apache2/bin/apxs --with-pdo-mysql
make
make install
```



编辑 `httpd.conf` 文件以调用 `PHP` 模块。 检查 `/usr/local/apache2/conf/httpd.conf` 文件，确保包含：

`PHP 8` 版本：

```shell
LoadModule php_module modules/libphp.so
```



告知 `Apache` 将特定的扩展名解析成 `PHP`，例如，让 `Apache` 将扩展名 `.php` 解析成 `PHP`。为了避免潜在的危险，例如上传或者创建类似 `exploit.php.jpg` 的文件并被当做 `PHP` 执行，我们不再使用 `Apache` 的 `AddType` 指令来设置。

这个配置文件在 `/etc/apache2` 路径下，具体名称可能不一样，本机的配置文件路径为：`/etc/apache2/conf-available/javascript-common.conf`：

```shell
#想将 .php，.php2，.php3，.php4，.php5，.php6，以及 .phtml 文件都当做 PHP 来运行
<FilesMatch "\.ph(p[2-6]?|tml)$">
    SetHandler application/x-httpd-php
</FilesMatch>

#将 .phps 文件由 PHP 源码过滤器处理，使得其在显示时可以高亮源码
<FilesMatch "\.phps$">
    SetHandler application/x-httpd-php-source
</FilesMatch>

#mod_rewrite 也有助于将那些不需要运行的 .php 文件的源码高亮显示，而并不需要将他们更名为 .phps 文件
RewriteEngine On
RewriteRule (.*\.php)s$ $1 [H=application/x-httpd-php-source]
```

**不要在正式生产运营的系统上启动 PHP 源码过滤器，因为这可能泄露系统机密或者嵌入的代码中的敏感信息。**



 Apache 和 PHP 都还有很多配置选项，可以在相应的源代码目录中使用 **`./configure --help`** 获得更多信息。



`php.ini` 是 `PHP` 的配置文件：

```shell
cp php.ini-development /usr/local/lib/php.ini
```





##### 安装中可能遇到的问题

1）**make 失败，报错：cc: fatal error: Killed signal terminated program cc1**

可以通过增大服务器SWAP大小来解决。

Swap（Swap 分区、Swap 内存），中文名是交换分区，类似于 Windows 中的虚拟内存，就是当内存不足的时候，把一部分硬盘空间虚拟成内存使用，从而解决内存容量不足的情况。

因此，Swap 分区的作用就是牺牲硬盘，增加内存，解决 VPS 内存不够用或者爆满的问题。

```shell
#获取要增加的2G的SWAP文件块
dd if=/dev/zero of=/swapfile bs=1k count=2048000

#创建SWAP文件
mkswap /swapfile

#激活SWAP文件
swapon /swapfile

#查看SWAP信息是否正确
swapon -s

#添加到fstab文件中让系统引导时自动启动
echo "/var/swapfile swap swap defaults 0 0" >> /etc/fstab
swapfile文件的路径在/var/下，编译完后, 如果不想要交换分区了, 可以删除。

#删除交换分区：
swapoff /swapfile
rm -rf /swapfile

作者：Goan_Z
链接：https://www.jianshu.com/p/a4ad05a51456
```



使用 swapon 挂载了 swap 分区后，可以看到 swap 分区从 0 变为 2 G：

```shell
root@VM-4-14-ubuntu:/# swapon swapfile
swapon: /swapfile: insecure permissions 0644, 0600 suggested.
root@VM-4-14-ubuntu:/# swapon -s
Filename				Type		Size	Used	Priority
/swapfile                              	file    	2047996	0	-2
root@VM-4-14-ubuntu:/# free -h
              total        used        free      shared  buff/cache   available
Mem:          1.9Gi       622Mi        84Mi       2.0Mi       1.2Gi       1.1Gi
Swap:         2.0Gi          0B       2.0Gi
root@VM-4-14-ubuntu:/# swapoff swapfile 
root@VM-4-14-ubuntu:/# free -h
              total        used        free      shared  buff/cache   available
Mem:          1.9Gi       621Mi        85Mi       2.0Mi       1.2Gi       1.1Gi
Swap:            0B          0B          0B
```



因为我的云服务器内存只有 2G，编译 PHP 的过程可能会占用超过 2 G 的内存，这时候就需要借用 2G 磁盘（swapfile）充当交换分区，作为内存缺少的补偿。



2）**Apache 无法解析 PHP 语句**

无论是在 `/etc/apache2/apache2.conf` 还是 `/etc/apache2/conf-available/javascript-common.conf` 抑或是 `/etc/apache2/sites-available/000-default.conf` 中增加上面的设置，都无法让 apache 成功解析 PHP 文件，最终还是在 `httpd.conf` 文件中加上 `AddType application/x-httpd-php .php`，方得始终。



#### 3. Ubuntu Apt 快捷安装

https://www.php.net/manual/zh/install.unix.debian.php











