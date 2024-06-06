

## 环境安装

### 一 环境安装 PHP8.0 Laravel9

下面介绍 Ubuntu 20.04 环境下，安装 LNMP，运行 Laravel 9.0 的经验。机器信息：

```shell
╭─root at VM-4-14-ubuntu in ~ 24-05-19 - 11:03:46
╰─○ uname -a
Linux VM-4-14-ubuntu 5.4.0-174-generic #193-Ubuntu SMP Thu Mar 7 14:29:28 UTC 2024 x86_64 x86_64 x86_64 GNU/Linux
```

 

**注意**：本教程的所有 `linux` 命令**均在 root 模式下执行**，普通用户模式下安装时，命令视情况加上 `sudo`  



#### 1. PHP 相关插件安装

`Laravel 9.0` 需要 PHP 版本大于等于 8.0，而 `ubuntu` apt 源自带的 PHP 版本只有 7.4，所以如果需要通过 apt 来安装，需要添加 PHP 8.0 的源：

```shell
apt install software-properties-common 
apt-add-repository ppa:ondrej/php # 添加php源地址
apt-get update
```

执行 php 8.0 安装命令：

```php
apt-get install php8.0-fpm php8.0-mysql php8.0-gd php8.0-mbstring php8.0-bcmath php8.0-xml php8.0-curl php8.0-redis php8.0-opcache php8.0-odbc
```

注意，如果之前安装过 `Apache`，`php-fpm` 包可能会提示安装失败，我选择直接将 `Apache` 卸载，后面会安装 `Nginx` 。

启动 `php-fpm` 服务：

```shell
systemctl start php-fpm
systemctl enable php-fpm #可选，开机自启
```



#### 2. 安装 Nginx

```shell
apt install nginx
systemctl start nginx
```

`Nginx` 配置文件位于 `/etc/nginx` 目录下。

修改 `/etc/nginx/sites-available` 目录下的配置文件，可以管理 nginx 对外展示的 IP，端口和页面等信息。

`default` 文件中为 `Nginx` 的默认 80 端口和页面信息。如果要新增服务，可以创建一个新的文件，并按需修改配置文件内容。

下面是一个使用 `index.php` 作为默认页面的配置文件，可供参考：

```shell
server {
	listen 8081; 
	listen [::]:8081;

	root /var/www/html/note/public;
	#server_name _;

	# Add index.php to the list if you are using PHP
	index index.php; 
	
	add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
	
	charset utf-8;

	location / {
        try_files $uri $uri/ /index.php?$query_string;
    }


	location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
	
	location ~ /\.ht {
		deny all;
	}
}

```

更多相关的信息可以参考：https://blog.csdn.net/weixin_44546342/article/details/128584526



#### 3. 安装 MySQL

```shell
apt install mariadb-server
systemctl start mysql
systemctl enable mysql
mysql -u root -p #设置 mysql 登陆密码
```



#### 4. 安装 Composer

```php
curl -sS https://getcomposer.org/installer | php
```

由于众所周知的原因，上面这条命令可能会很慢，可以去官网下载最新的 Composer（`.phar` 文件），然后通过 `scp` 命令发送到服务器上。

```shell
mv composer.phar /usr/local/bin/composer
```

检查 Composer 是否安装成功：

```php
composer --version
```

将 Composer 下载源更换为国内源：

```shell
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```



#### 5. 运行 Laravel 项目

安装 Laravel 安装器：

```shell
composer global require laravel/installer
```

在 shell 脚本内（我用的是 `zsh` 所以路径为，`/etc/zsh/zprofile`）加上 `laravel` 可执行程序的路径，这样在任何位置都可以运行 laravel 命令：

```shell
export PATH=$PATH:/root/.config/composer/vendor/bin
```

查看 Laravel 安装器的信息：

```shell
laravel -v
```

创建新的 Laravel 项目：

```shell
laravel new [project_name]
```

 启动 Laravel 项目：

```shell
cd xxx
php artisan serve
```

访问 127.0.0.1:8000 即可查看项目页面。

**注意：** 如果是在服务器部署，则需要指定服务器的一个网卡 IP，或直接使用 `0.0.0.0` ：

```php
php artisan serve --host=0.0.0.0 --port=8080
```

如果端口不是 80 这些默认开启的端口，需要确保端口已经开放，可以在服务器提供商的网站管理页面上开放端口。

这样就可以通过服务器公网 IP + 端口号来访问 laravel 项目啦！

![](https://img-blog.csdnimg.cn/08fdbcf8a4ca489d9f657401a236ac12.png)



至此，Laravel 环境配置大功告成！

本 PHP 菜鸟在尝试了 Windows XAMPP 环境安装（成功），Linux Sail 环境安装（失败），LAMP 环境安装（失败），终于在重装了系统后安装成功了（之前因为软件包的依赖问题，导致 dpkg & apt 罢工，尝试多种方案解决无果）。

环境配置失败的心路历程可以通过 doc 目录下的 《linux下laravel环境配置失败经验》 一文窥探一二。

虽然环境配置让我掉了不少头发，可是在解决问题的过程中，还是学到了很多新的知识，尤其把下载软件包，删除软件包这块的命令背熟了hh 

之前配置环境中会望而却步的错误，这次也会在崩溃后，耐着性子重新思考解决的办法。忙里偷闲甚至配置 zsh 和 neovim！



参考：

- [Laravel框架学习笔记——Laravel环境配置及安装（Ubuntu20.04为例）](https://blog.csdn.net/weixin_44546342/article/details/128584526)
- [更改laravel的默认端口8000](https://blog.csdn.net/TO_Web/article/details/119868307)
- [PHP artisan serve 运行项目之后不能用 ip 地址访问](https://blog.csdn.net/qq_26282869/article/details/110525416)
- [How to Install Laravel on Ubuntu 20.04](https://dev.to/bilalniaz15/how-to-install-laravel-on-ubuntu-2004-lts-58hk)
- https://learnku.com/docs/laravel/9.x/installation/12200



### 二 PHP8.3 Laravel 11

`laravel` 11 开始使用 `sqlite`，需要安装 `sqlite` 插件。

```shell
apt install php8.3 php8.3-xml php8.3-curl php8.3-mbstring php8.3-sqlite3 php8.3-mysql
```

`apache` 服务启动失败，因为 `nginx` 占用了端口 80，停止 nginx 重启 apache 服务器即可。

如果遇到报错：

```shell
- Root composer.json requires fruitcake/php-cors ^1.3, found fruitcake/php-cors[dev-feat-setOptions, dev-master, dev-main, dev-test-8.2, v0.1.0, v0.1.1, v0.1.2, v1.0-alpha1, ..., 1.2.x-dev (alias of dev-master)] but it does not match the constraint
```

可能是因为 `composer` 源替换为了阿里云源的原因，执行以下命令重置源：

```shell
composer config -g --unset repos.packagist
composer config -g --list
```

执行 `laravel` 命令

```shell
composer create-project laravel/laravel:^11 test
```

换回阿里源：

```shell
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```



## 项目

### 一 任务说明 

**任务说明：**

1. **项目名称：** 记事本
2. **技术栈：** Laravel
3. **功能需求：**
   - **记录包含标题和内容**
   - 给单条记录添加 tag
     - 使用 Laravel 提供的 Relation 功能实现
   - 恢复被删除的记录
     - 使用软删除
   - 支持复制单条记录
     - 复制后的记录标题需要按照以下规则修改：
       - 如果被复制的记录标题是 "Title"，如果数据库中不存在标题为 "Title(1)" 的记录，复制后的记录标题是 "Title(1)"。
       - 如果被复制的记录标题是 "Title"，但是数据库中已经存在标题为 "Title(1)" 的记录，复制后的记录标题是 "Title(2)"；如果 "Title(2)" 也存在并且 "Title(3)" 不存在，复制后的记录标题是 "Title(3)"，以此类推。
       - 如果被复制的记录标题是 "Title(99)"，如果数据库中不存在标题为 "Title(99)(1)" 的记录，复制后的记录标题是 "Title(99)(1)"；如果存在，复制后的记录标题是 "Title(99)(2)"。
       - 如果被复制的记录标题是 "Title(99)(99)"，如果数据库中不存在标题为 "Title(99)(99)(1)" 的记录，复制后的记录标题是 "Title(99)(99)(1)"，以此类推。
4. **测试需求：**
   - 给记事本项目加上单元和功能测试
5. **持续集成：**
   - 实现 GitHub Action 持续集成



```
  public function copy($id)
    {
        $note = Note::find($id);
        $newTitle = $this->generateTitle($note->title);
        $newNote = $note->replicate();
        $newNote->title = $newTitle;
        $newNote->save();
        return response()->json($newNote);
    }

    private function generateTitle($title)
    {
        $newTitle = $title;
        $i = 1;
        while (Note::where('title', $newTitle)->exists()) {
            $newTitle = "{$title}($i)";
            $i++;
        }
        return $newTitle;
    }
```



### 二 开发



### 三 测试



### 四 持续集成



### 五 Debug 日志

#### 1. SQLSTATE[HY000]: General error: 1824

SQLSTATE[HY000]: General error: 1824 Failed to open the referenced table 'notes' (Connection: mysql, SQL: alter table `notes_tags` add constraint `notes_tags_note_id_foreign` foreign key (`note_id`) references `notes` (`id`) on delete cascade)

```shell
╭─root at VM-4-14-ubuntu in ~/php/note 24-06-06 - 4:49:46
╰─○ php artisan migrate:fresh

  Dropping all tables .............................................................................................. 300.73ms DONE

   INFO  Preparing database.

  Creating migration table .......................................................................................... 63.41ms DONE

   INFO  Running migrations.

  0001_01_01_000000_create_users_table ............................................................................. 397.04ms DONE
  0001_01_01_000001_create_cache_table ............................................................................. 165.54ms DONE
  0001_01_01_000002_create_jobs_table .............................................................................. 271.93ms DONE
  2024_06_05_193600_create_notes_table .............................................................................. 61.56ms DONE
  2024_06_05_193730_create_tags_table .............................................................................. 536.64ms DONE

```

`php artisan migrate:fresh` 在建表时是根据 migrations 目录下文件的顺序进行的。如果表 1 中存在一个外键指向表 2，那么表 2 应该先于表 1 创建。

https://stackoverflow.com/questions/60826299/general-error-1824-failed-to-open-the-referenced-table







