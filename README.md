



#### 前置环境

1. `xampp`
2. `phpstorm`
3. `git`



#### `mysql` 使用

**图形化界面** 

首先打开 `xampp-control.exe` ，开启 Apache 和 MySQL 

![image-20240410185722333](C:\Users\78172\AppData\Roaming\Typora\typora-user-images\image-20240410185722333.png)

浏览器访问 `localhost/dashboard`，点击 `phpMyAdmin` 进入 MySQL 可视化操作界面。

![image-20240410185805133](C:\Users\78172\AppData\Roaming\Typora\typora-user-images\image-20240410185805133.png)



**命令行**

```shell
C:\Users\78172>C:\xampp\mysql\bin\mysql.exe -uroot -p
Enter password:
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 38
Server version: 10.4.28-MariaDB mariadb.org binary distribution

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]>
```



将 `C:\xampp\mysql\bin\` 加入系统变量中，下次打开 `mysql` 时就不需要加路径了

```cpp
C:\Users\78172>mysql -uroot -p
Enter password:
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 41
Server version: 10.4.28-MariaDB mariadb.org binary distribution

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]>
```



#### `node.js` 下载

https://nodejs.org/en 

下载 LTS 版本即可。

```shell
78172@DESKTOP-82UG4OQ MINGW64 ~/Desktop
$ node -v
v20.12.1

78172@DESKTOP-82UG4OQ MINGW64 ~/Desktop
$ npm -v
10.5.0
```



#### `laravel` 项目创建

https://laravel.com/docs/11.x

```shell
composer create-project laravel/laravel example-app

```











































