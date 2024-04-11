#### `mwget` 

`wget` 相对于浏览器来说，速度会比较偏慢，特别是国外的网站。

刚好经常用的 `xftp` 无法正常使用了，于是开始折腾 `mwget` 。

`mwget` 是一个多线程下载应用，可以明显提高下载速度。

下面来看一下 `mwget` 安装步骤：

```shell
#!/bin/bashwget http://jaist.dl.sourceforge.net/project/kmphpfm/mwget/0.1/mwget_0.1.0.orig.tar.bz2
yum install bzip2 gcc-c++ openssl-devel intltool -y
bzip2 -d mwget_0.1.0.orig.tar.bz2
tar -xvf mwget_0.1.0.orig.tar 
cd mwget_0.1.0.orig
./configure 　　#一般用来生成 Makefile，为下一步的编译做准备，你可以通过在 configure 后加上参数来对安装进行控制，比如代码:./configure –prefix=/usr 意思是将该软件安装在/usr下面
make　　　　　　 #编译，大多数的源代码包都经过这一步进行编译
make install　　#开始安装echo "至此，安装完成"
```

https://www.cnblogs.com/biaopei/p/12017150.html

