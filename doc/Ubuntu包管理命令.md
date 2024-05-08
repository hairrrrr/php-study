### 一 dpkg

#### 1. `dpkg -l` 或  `dpkg --list`

直接检查软件包是否安装



#### 2. `dpkg --configure -a`

这个命令是针对 `dpkg` 包管理器的,用于配置所有未配置的软件包。`-a` 选项代表 `--pending`。具体作用如下:

- 扫描系统中所有已安装但未配置的软件包。
- 对于每个未配置的软件包,执行其配置脚本(`postinst`)以完成配置过程。
- 配置过程可能包括生成配置文件、创建必要的目录和文件、设置权限等操作。

通常,`sudo apt-get -f install` 命令会先尝试通过修复依赖关系来解决问题。如果仍然存在未配置的软件包,它会调用 `dpkg` 来配置这些包。因此,`sudo dpkg --configure -a` 通常作为 `sudo apt-get -f install` 命令的补充,用于处理该命令无法解决的未配置的软件包。





### 二 apt

#### 1. `apt-get -f install`

该命令的 `-f` 选项代表 `--fix-broken` 或 `--fix-missing`。它的主要作用是尝试修复安装过程中出现的任何依赖问题或损坏的软件包。具体来说,该命令执行以下操作:

- 检查已安装的软件包是否存在损坏或未配置的情况。
- 分析依赖关系,并尝试下载缺失的依赖包。
- 根据依赖关系,重新配置已安装的软件包或安装缺失的软件包。
- 最终目标是使系统中所有的软件包都处于一致的、已配置的状态。



#### 2. `apt-cache policy`

```shell
gnome-terminal:
  Installed: 3.36.2-1ubuntu1~20.04
  Candidate: 3.36.2-1ubuntu1~20.04
  Version table:
 *** 3.36.2-1ubuntu1~20.04 500
        500 http://us.archive.ubuntu.com/ubuntu focal/main amd64 Packages
        100 /var/lib/dpkg/status
```

在输出中查看 `Installed` 一行:

- 如果这一行显示了软件包的版本号,则表示 `gnome-terminal` 已经安装。
- 如果这一行显示 `none`,则表示未安装。



