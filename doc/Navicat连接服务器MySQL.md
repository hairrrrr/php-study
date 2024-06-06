## 一 Navicat 安装

按照下面这篇博客教程操作即可：

https://www.cnblogs.com/kkdaj/p/16260681.html#gallery-5



## 二 连接远程 MySQL

环境腾讯云轻量服务器，系统配置信息如下：

```shell
╰─○ uname -a
Linux VM-4-14-ubuntu 5.4.0-174-generic #193-Ubuntu SMP Thu Mar 7 14:29:28 UTC 2024 x86_64 x86_64 x86_64 GNU/Linux
```

#### 1. 腾讯云管理面板开放 3306 端口防火墙

![1.png](https://s2.loli.net/2024/06/02/SZj5gsnAi64X3lw.png)



#### 2. 确认 MySQL 监听的 IP 地址和端口

```shell
netstat -plnt | grep mysql
```

查看 MySQL 是否在监听所有网络接口（0.0.0.0）或仅在监听本地环回接口（127.0.0.1）。如果只监听在127.0.0.1，那么你需要修改MySQL配置文件以便它能从其他接口接收连接。通常情况下，这个配置文件位于 `/etc/mysql/mysql.conf.d/mysqld.cnf`，找到 `bind-address` 这一项并将其更改为 `0.0.0.0`。

注意，如果是安装的软件包是 mariadb，可能这个路径不一致，可以查看 `/etc/mysql/my.cnf` 中包含的文件夹，并在该文件夹中寻找类似的配置文件，进行修改。

```
╭─root at VM-4-14-ubuntu in ~ 24-06-02 - 16:14:59
╰─○ cat /etc/mysql/mysql.conf.d/mysqld.cnf
[mysqld]
#
# * Basic Settings
#
user            = mysql
# pid-file      = /var/run/mysqld/mysqld.pid
# socket        = /var/run/mysqld/mysqld.sock
 port           = 3306

# Instead of skip-networking the default is now to listen only on
# localhost which is more compatible and is not less secure.
bind-address            =  0.0.0.0
```

然后重启 `mysql` 服务：

```shell
sudo systemctl restart mysql
```



#### 3. 检查 MySQL 权限

确保 `root` 用户有权限从非 `localhost` 登录。你可以登录 `MySQL` 然后使用下面 `SQL`命令查看用户权限：

```shell
$ mysql -u root -p
mysql>use mysql;
mysql>select user,host from user;
+-----------+------------------+
| host      | user             |
+-----------+------------------+
| localhost | debian-sys-maint |
| localhost | mysql.infoschema |
| localhost | mysql.session    |
| localhost | mysql.sys        |
| localhost | root             |
+-----------+------------------+
8 rows in set (0.00 sec)
```

如果 `root` 用户的 `host` 字段是 `localhost`，那么你需要更改权限让 `root` 用户可以从任何主机登录。

```shell
mysql>CREATE USER 'root'@'%' IDENTIFIED BY 'your password';#创建一个允许从任何主机登录的root用户
mysql>GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';#授予新用户所有权限
mysql>FLUSH PRIVILEGES;#刷新权限
mysql>>select user,host from user;
+-----------+------------------+
| host      | user             |
+-----------+------------------+
| %         | root             |#允许远程登陆
| localhost | debian-sys-maint |
| localhost | mysql.infoschema |
| localhost | mysql.session    |
| localhost | mysql.sys        |
| localhost | root             |#允许从本地登陆
+-----------+------------------+
```

**注意：** 这里出现了两个 `root`，这是两个不同的账户！作用时不同的，上面也做了注释。如何区分 `user` 相同的不同账户呢？这在第三章《问题》会详细说明。



#### 4. 使用 Navicat 连接远程

![2.png](https://s2.loli.net/2024/06/02/suVEYezNw2HGdJT.png)

![3.png](https://s2.loli.net/2024/06/02/j3oC5p97XNgynvK.png)



参考：

1. [mysql8.0数据库无法被远程连接问题排查（mysql远程连接设置方法）‘root‘@‘localhost‘和‘root‘@‘%‘（无法连接mysql无法远程连接、mysql连接被拒绝）](https://blog.csdn.net/Dontla/article/details/133213538)



### 三 问题

做完上面这些，第一次尝试远程成功了。可惜夜长梦多，第二天睡醒就离奇的连接不上了。

#### 1. 防火墙的问题？

```shell
sudo ufw status
```

第一次执行显示 `ufw` 时 `enable` 的。这说明防火墙压根没开启，不是防火墙的问题，可是我当时没有意会，还是继续坚持开启防火墙。

```shell
$sudo ufw allow 3306/tcp 
$ ufw reload
```

执行 `ufw reload`时，显示 `firewalld`服务没有开启，无法 `reload`。即使下载 frewalld 服务并开启，还是会出现相同报错，参考这篇回答：

https://superuser.com/questions/590600/ufw-is-active-but-not-enabled-why

`nv /etc/ufw/ufw.conf` 将 `ENABLED=yes`就可以了。



修改 `iptables`

`iptables` 定义了网络访问规则，它工作在内核中，是一个网络过滤器。

```shell
sudo iptables -I INPUT -p tcp --dport 3306 -j ACCEPT
```

表示添加接收 `3306` 端口的规则。

- `-I INPUT` 将当前命令插入在 `filter` 链的第一位置。
- `-p tcp` 表示添加 `tcp` 协议的扩展。
- `--dport XX-XX`：指定目标端口。
- `-j ACCEPT`: 规定的动作，这里为接收。

完成后，保存修改的配置`sudo iptables-save`。

这些都做完，还是连接不上，并不是防火墙的问题！



- 参考：[解决mysql无法远程连接的问题 ](https://www.cnblogs.com/deep-deep-learning/p/14841488.html)

  

#### 2. telnet ip 3306 失败？

这让我又把目光转向了端口问题。进行了大量无用功后发现，telnet 本来就无法跟 MySQL 服务连接，因为它压根不是 MySQL 客户端。

错误示范文章：https://www.cnblogs.com/ziroro/p/9479869.html



#### 3. 服务器本地账号密码正确也无法登陆 MySQL？

第二章，第三节中，如果你是通过：

```shell
mysql>update user set host='%' where user='root';
```

你会将 user 表改为：

```shell
+-----------+------------------+
| host      | user             |
+-----------+------------------+
| localhost | debian-sys-maint |
| localhost | mysql.infoschema |
| localhost | mysql.session    |
| localhost | mysql.sys        |
| %         | root             |
+-----------+------------------+
```

这样 `root` 账号**只能**远程访问 `MySQL` 而无法本地访问了。

最后只能**重装** `MySQL` 解决这个问题。

使用这条语句的的教程中文搜索结果很多，害人不浅！



### 四  solution

前面我们说了，`user` 表中有两个 `root`，这是两个不同的账户，当我们想使用 `host` 为 `localhost` 的账户时，采用下面这样的方式登陆 `MySQL`：

```shell
mysql -hlocalhost -uroot -p
```

再添加一个 host 为 `127.0.0.1` 的 `root`：

```shell
mysql> INSERT INTO mysql.user (Host, User) VALUES ('127.0.0.1', 'root');
mysql> select host,user from user;
+-----------+------------------+
| host      | user             |
+-----------+------------------+
| %         | root             |
| %         | wxc              |
| 127.0.0.1 | root             |
| localhost | debian-sys-maint |
| localhost | mysql.infoschema |
| localhost | mysql.session    |
| localhost | mysql.sys        |
| localhost | root             |
+-----------+------------------+
```



Navicat 设置：

![](https://img2018.cnblogs.com/blog/1656952/201907/1656952-20190705214402984-1454339889.png)

![](https://img2018.cnblogs.com/blog/1656952/201907/1656952-20190705214519764-88496090.png)

参考：

- [Unable to connect to remote host: Connection timed out when trying to telnet to MySQL?](https://serverfault.com/questions/331235/unable-to-connect-to-remote-host-connection-timed-out-when-trying-to-telnet-to)
- [Navicat连接腾讯云服务器上的数据库](https://www.cnblogs.com/nzcblogs/p/11141023.html)





### 后记 MySQL被黑

用这个命令修改密码：

```
 ALTER USER 'root'@'127.0.0.1' IDENTIFIED BY 'xxx';
```

记得 root 对应的 `%`，`localhost` 和 `127.0.0.1` 都修改

参考：https://www.jianshu.com/p/5409133efcfa





