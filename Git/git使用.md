**创建和使用git ssh key**

首先设置git的user name和email：

    git config --global user.name "xxx"
    git config --global user.email "xxx@gmail.com"

查看git配置：

    git config --list

然后生成SHH密匙,如果没有密钥则不会有此文件夹，有则备份删除：

    ssh-keygen -t rsa -C "xxx@gmail.com"

查看是否已经有了ssh密钥:

    cd ~/.ssh

按3个回车，密码为空这里一般不使用密钥
最后得到了两个文件：`id_rsa`和`id_rsa.pub`
把`id_rsa.pub`里字符序列拷贝到需要的地方
注意：密匙生成就不要改了，如果已经生成到`~/.ssh`文件夹下去找

**git变更项目地址:**

    git remote set-url origin git@192.168.6.70:res_dev_group/test.git
    git remote -v

**查看某个文件的修改历史:**

    git log --pretty=oneline 文件名 # 显示修改历史
    git show 356f6def9d3fb7f3b9032ff5aa4b9110d4cca87e # 查看更改

**git add文件取消:**

在git的一般使用中，如果发现错误的将不想提交的文件add进入index之后，想回退取消，则可以使用命令：

    git reset HEAD <file>...

同时git add完毕之后，git也会做相应的提示

**git删除文件：**

    删除文件跟踪并且删除文件系统中的文件file1       git rm file1
    提交刚才的删除动作，之后git不再管理该文件       git commit

    删除文件跟踪但不删除文件系统中的文件file1       git rm --cached file1
    提交刚才的删除动作，之后git不再管理该文件。但是文件系统中还是有file1   git commit

**版本回退**

版本回退用于线上系统出现问题后恢复旧版本的操

回退到的版本	`git reset --hard 248cba8e77231601d1189e3576dc096c8986ae51`

回退的是所有文件，如果后悔回退可以git pull就可以了

**历史版本对比**

查看日志	`git log`

查看某一历史版本的提交内容	`git show 4ebd4bbc3ed321d01484a4ed206f18ce2ebde5ca`，这里能看到版本的详细修改代码。

对比不同版本	`git diff c0f28a2ec490236caa13dec0e8ea826583b49b7a       2e476412c34a63b213b735e5a6d90cd05b014c33`

**分支的意义与管理**

创建分支可以避免提交代码后对主分支的影响，同时也使你有了相对独立的开发环境。分支具有很重要的意义。

创建并切换分支，提交代码后才能在其它机器拉分支代码`git checkout -b new_branch`

查看当前分支	`git branch`

切换到master分支	`git checkout master`

合并分支到当前分支`git merge new_branch`，合并分支的操作是从`new_branch`合并到`maste`r分支，当前环境在`master`分支。

删除分支`git branch -d new_branch`

**git冲突文件编辑**

冲突文件冲突的地方如下面这样

    a123
    <<<<<<< HEAD
    b789
    =======
    b45678910
    >>>>>>> 6853e5ff961e684d3a6c02d4d06183b5ff330dcc
    c

冲突标记`<<<<<<<`（7个<）与`=======`之间的内容是我的修改，`=======`与`>>>>>>>`之间的内容是别人的修改。此时，还没有任何其它垃圾文件产生。你需要把代码合并好后重新走一遍代码提交流程就好了。

**git fetch**

一旦远程主机的版本库有了更新（Git术语叫做commit），需要将这些更新取回本地，这时就要用到git fetch命令

    git fetch <远程主机名>
上面命令将某个远程主机的更新，全部取回本地。

默认情况下，git fetch取回所有分支（branch）的更新。如果只想取回特定分支的更新，可以指定分支名。

    $ git fetch <远程主机名> <分支名>

比如，取回origin主机的master分支。

    git fetch origin master

所取回的更新，在本地主机上要用"远程主机名/分支名"的形式读取。比如origin主机的master，就要用origin/master读取。

git branch命令的-r选项，可以用来查看远程分支，-a选项查看所有分支。

      git branch -r
      origin/master
    
      git branch -a
    * master
      remotes/origin/master

上面命令表示，本地主机的当前分支是master，远程分支是origin/master。

取回远程主机的更新以后，可以在它的基础上，使用git checkout命令创建一个新的分支。

     git checkout -b newBrach origin/master

上面命令表示，在origin/master的基础上，创建一个新分支。
此外，也可以使用git merge命令或者git rebase命令，在本地分支上合并远程分支。

    git merge origin/master
    # 或者
    git rebase origin/master

上面命令表示在当前分支上，合并origin/master

**git add -A / . / -u的区别**

	 git add -A    stages All
	 git add .     stages new and modified, without deleted
	 git add -u    stages modified and deleted, without new
**git tag用法**
	
	打标签
	git tag -a v1.01 -m "Relase version 1.01"
	注解：git tag 是打标签的命令，-a 是添加标签，其后要跟标签名，-m 及后面的字符串是对该
	标签的注释
	
	提交标签
	git push origin -tags
	注解：就像git push origin master 把本地修改提交到远程仓库一样，-tags可以把本地的打的
	标签全部提交到远程仓库。
	
	删除标签
	git tag -d v1.01
	注解：-d 表示删除，后面跟要删除的tag名字

	删除远程标签
	git push origin :refs/tags/v1.01

	查看标签
	git tag或则git tag -l