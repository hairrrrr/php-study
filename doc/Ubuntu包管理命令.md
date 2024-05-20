### 一 dpkg

#### 1. `dpkg -l` 或  `dpkg --list`

直接检查软件包是否安装



#### 2. `dpkg --configure -a`

这个命令是针对 `dpkg` 包管理器的,用于配置所有未配置的软件包。`-a` 选项代表 `--pending`。具体作用如下:

- 扫描系统中所有已安装但未配置的软件包。
- 对于每个未配置的软件包,执行其配置脚本(`postinst`)以完成配置过程。
- 配置过程可能包括生成配置文件、创建必要的目录和文件、设置权限等操作。

通常,`sudo apt-get -f install` 命令会先尝试通过修复依赖关系来解决问题。如果仍然存在未配置的软件包,它会调用 `dpkg` 来配置这些包。因此,`sudo dpkg --configure -a` 通常作为 `sudo apt-get -f install` 命令的补充,用于处理该命令无法解决的未配置的软件包。



#### 3. `dpkg --get-selections | grep -v deinstall`

过滤掉所有没安装的软件包。



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



### 三 通过添加 PGP 密钥安装

以安装 nodejs 为例：

```shell
# 安装 Node.js 仓库的 PGP 密钥
sudo apt install curl
curl -sL https://deb.nodesource.com/setup_18.x | sudo -E bash -

# 安装 Node.js
sudo apt install nodejs
```

1. `curl -sL https://deb.nodesource.com/setup_18.x`
   - `curl` 是一个命令行工具,用于通过 URL 传输数据。
   - `-s` 选项表示静默模式,不输出进度信息。
   - `-L` 选项表示要跟随重定向。
   - `https://deb.nodesource.com/setup_18.x` 是一个 URL，指向 `Node.js` 官方的安装脚本。
2. `|` 是管道符号,用于将前一个命令的输出作为后一个命令的输入。
3. `sudo -E bash -`
   - `sudo` 命令用于以超级用户权限执行后面的命令。
   - `-E` 选项用于保留当前shell的环境变量。
   - `bash -` 表示在当前 shell 中启动一个新的 bash 实例,并执行管道输入的命令。

---

**`bash` 和 `bash -` 的区别** 

简单来说,`bash` 仅从父 shell 继承环境变量,而 `bash -` 则会从父 shell 继承环境变量、选项设置,并读取启动脚本设置新的环境。

通常情况下,我们更倾向于使用 `bash` 来启动交互式子 shell,因为它相对轻量级一些。但如果你需要在新的 shell 实例中设置更多的环境变量和选项,使用 `bash -` 可能会更合适。

另一个需要注意的点是,当你以 `sudo` 执行命令时,如果使用 `bash` 启动新的 shell,它并不会从 root 用户的启动脚本中继承任何配置,因此可能会导致一些环境问题。这种情况下,使用 `sudo bash -` 会更加合适,因为它会加载 root 用户的环境配置。

---

整个命令的作用是:

1. 使用 `curl` 从 Node.js 官方网站下载适用于当前系统的设置脚本。
2. 以超级用户权限在当前 shell 中执行下载的脚本。

执行这个脚本会自动完成以下几个步骤:

1. 检测当前 Linux 发行版的版本信息。
2. 根据发行版信息,获取并导入 Node.js 仓库的 GPG 密钥。
3. 创建 Node.js 仓库的 apt 源列表文件。
4. 通过 apt 源列表,可以使用 `apt-get install nodejs` 命令从仓库安装 Node.js。



`apt-key` 是 Debian/Ubuntu 系统中用于管理加密密钥的命令行工具,常用于添加和删除软件源的 GPG 密钥。以下是一些常用的 `apt-key` 相关命令:

**列出受信任的密钥**

```
apt-key list
```

这将列出当前系统中所有受信任的密钥。

**添加密钥**

```
apt-key add /path/to/keyfile.asc
```

将指定的密钥文件添加到受信任的密钥列表中。

**从键服务器添加密钥**

```
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys KEYID
```

从指定的键服务器获取并添加指定的密钥ID。

**删除密钥**

```
apt-key del KEYID
```

删除指定的密钥ID。

**添加远程密钥**

```
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys KEYID
```

从指定的键服务器获取并添加指定的密钥ID。

**更新密钥环**

```
apt-key update
```

在添加或删除密钥后,使用此命令更新密钥环。

**导出密钥**

```
apt-key export KEYID > output.asc
```

将指定的密钥ID导出到 output.asc 文件中。





