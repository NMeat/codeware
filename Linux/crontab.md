**linux shell 之 crontab（定时任务）详解**

rontab命令常见于Unix和类Unix的操作系统之中，用于设置周期性被执行的指令。该命令从标准输入设备读取指令，并将其存放于“crontab”文件中，以供之后读取和执行。该词来源于希腊语 chronos(χρνο)，原意是时间,时常，crontab储存的指令被守护进程激活， crond常常在后台运行，每一分钟检查是否有预定的作业需要执行。这类作业一般称为cron jobs。

    crontab -e
    #此时会进入 vi 的编辑画面让您编辑工作！注意到，每项工作都是一行
    #分 时 日  月 周  |<==============任务的完整命令行
     *  *  *  *  *   /home/blue/do/rsyncfile.sh

默认情况下，任何使用者只要不被列入 /etc/cron.deny 当中，那么他就可以直接下达『 crontab -e 』去编辑自己的例行性命令了！整个过程就如同上面提到的，会进入 vi 的编辑画面， 然后以一个工作一行来编辑，编辑完毕之后输入『 :wq 』储存后离开 vi 就可以了！ 

 假如我们需要修改为每5分钟运行数据同步的脚本，那么同样使用 crontab -e 进入编辑：

    */5 * * * *  /home/blue/do/rsyncfile.sh
假如服务器出了问题，有一天的数据没有同步，于是我们就需要补数据了，假设这个补数据的脚本是/home/blue/do/rsyncfile_day.sh,但是白天是高峰期，晚上用户不多，是低峰期，我们补数据会占用大量带宽，尤其是白天，会影响正常业务，所以一般我们可以让补数据任务在凌晨2点开始跑，那么同样使用crontab -e 进入编辑：

    0 2 1 4 *  /home/blue/do/rsyncfile_day.sh

这样，在4月1号凌晨2点0分就会开始启动我们的补数据的脚本了。

同步数据，在互联网公司是再平常不过的任务了，这里大家可以看到crontab的魅力所在了，只需要写最简单的业务逻辑，把调度交给crond做，就完成了一个可靠性很高的一项任务了，如果要自己去额外写这种调度程序，不知道要花多少精力才能做到可靠稳定。

crontab的语法

    crontab [-u username] [-l|-e|-r]
    选项与参数：
    -u  ：只有 root 才能进行这个任务，亦即帮其他使用者创建/移除 crontab 工作排程；
    -e  ：编辑 crontab 的工作内容
    -l  ：查阅 crontab 的工作内容
    -r  ：移除所有的 crontab 的工作内容，若仅要移除一项，请用 -e 去编辑

查询使用者目前的 crontab 内容:

    crontab -l
    */5 * * * *  /home/blue/do/rsyncfile.sh
    0 2 1 4 *  /home/blue/do/rsyncfile_day.sh

清空使用者目前的 crontab:
    
    crontab -r
    crontab -l
    no crontab for blue

如果你想删除当前用户的某一个crontab任务，那么使用crontab -e进入编辑器，再删除对应的任务

**crontab的限制**

> 　　/etc/cron.allow：将可以使用 crontab 的帐号写入其中，若不在这个文件内的使用者则不可使用 crontab；

> 　　/etc/cron.deny：将不可以使用 crontab 的帐号写入其中，若未记录到这个文件当中的使用者，就可以使用 crontab

以优先顺序来说， /etc/cron.allow 比 /etc/cron.deny 要优先， 而判断上面，这两个文件只选择一个来限制而已，因此，建议你只要保留一个即可， 免得影响自己在配置上面的判断！一般来说，系统默认是保留 /etc/cron.deny ， 你可以将不想让他运行 crontab 的那个使用者写入 /etc/cron.deny 当中，一个帐号一行！

**crontab的原理**

当使用者使用 crontab 这个命令来创建工作排程之后，该项工作就会被纪录到 /var/spool/cron/ 里面去了，而且是以帐号来作为判别的喔！举例来说， blue 使用 crontab 后， 他的工作会被纪录到 /var/spool/cron/blue 里头去！但请注意，不要使用 vi 直接编辑该文件， 因为可能由於输入语法错误，会导致无法运行 cron 喔！另外， cron 运行的每一项工作都会被纪录到 /var/log/cron 这个登录档中，所以罗，如果你的 Linux 不知道有否被植入木马时，也可以搜寻一下 /var/log/cron 这个登录档呢！

crond服务的最低侦测限制是『分钟』，所以『 cron 会每分钟去读取一次 /etc/crontab 与 /var/spool/cron 里面的数据内容 』，因此，只要你编辑完 /etc/crontab 这个文件，并且将他储存之后，那么 cron 的配置就自动的会来运行了！

备注：在 Linux 底下的 crontab 会自动的帮我们每分钟重新读取一次 /etc/crontab 的例行工作事项，但是某些原因或者是其他的 Unix 系统中，由於 crontab 是读到内存当中的，所以在你修改完 /etc/crontab 之后，可能并不会马上运行， 这个时候请重新启动 crond 这个服务吧！『/etc/init.d/crond restart』 
