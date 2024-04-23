

### 一 Commit Message

本节介绍如何使用 Commitizen 提交规范化的 Commit message 

学习文档：https://ruanyifeng.com/blog/2016/01/commit_message_change_log.html

#### 1. Commit Message 规范

**Header** 

 type 字段为必需：

- feat：新功能（feature）
- fix：修补bug
- docs：文档（documentation）
- style： 格式（不影响代码运行的变动）
- refactor：重构（即不是新增功能，也不是修改bug的代码变动）
- test：增加测试
- chore：构建过程或辅助工具的变动

scope 字段可选，用于说明 commit 影响的范围，比如数据层、控制层、视图层等等，视项目不同而不同。

subject 字段为必需，commit 目的的简短描述，不超过50个字符：

- 以动词开头，使用第一人称现在时，比如`change`，而不是`changed`或`changes`
- 第一个字母小写
- 结尾不加句号（`.`）



**Footer**

1. 不兼容变动：如果当前代码与上一个版本不兼容，则 Footer 部分以`BREAKING CHANGE`开头，后面是对变动的描述、以及变动理由和迁移方法。
2. 关闭 Issue：如果当前 commit 针对某个issue，那么可以在 Footer 部分关闭这个 issue 。
3. Revert：如果当前 commit 用于撤销以前的 commit，则必须以`revert:`开头，后面跟着被撤销 Commit 的 Header。



具体的写法参考原博客



#### 2. Commitizen

[Commitizen](https://github.com/commitizen/cz-cli) 是一个撰写合格 Commit message 的工具。

安装命令如下。

```bash
$ npm install -g commitizen
```

然后，在项目目录里，运行下面的命令，使其支持 Angular 的 Commit message 格式。

```bash
$ commitizen init cz-conventional-changelog --save --save-exact
```

以后，凡是用到`git commit`命令，一律改为使用`git cz`。这时，就会出现选项，用来生成符合格式的 Commit message。



windows 中使用 git bash 时可能会发现 `git cz` 后方向键无法选择：

![](https://img-blog.csdnimg.cn/be0ab8d463c34c31930e16c8dec28334.png)



将命令修改为：

```shell
winpty git cz
```

即可。

参考文章：https://blog.csdn.net/sinat_36568888/article/details/128410142



### 二 Git Flow

https://morningspace.github.io/tech/git-workflow-4/







