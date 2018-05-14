#### 系统

```
head -n 1 /etc/issue		#查看操作系统版本  CentOS release 6.6 (Final)
hostname					#查看计算机名  xxoo
```

#### cpu

lscpu命令，查看的是cpu的统计信息:

```
Architecture:          x86_64			#cpu架构
CPU op-mode(s):        32-bit, 64-bit
Byte Order:            Little Endian	#小尾序
CPU(s):                32				#总共有32核
On-line CPU(s) list:   0-31
Thread(s) per core:    2				#每个cpu核，只能支持2个线程
Core(s) per socket:    8
Socket(s):             2				#主板上插cpu的槽的数目，也就是可以插入的物理CPU的个数
NUMA node(s):          1
Vendor ID:             GenuineIntel     #cpu生成厂商
CPU family:            6				#CPU产品系列代号
Model:                 63
Stepping:              2
CPU MHz:               2394.439
BogoMIPS:              4788.58
Virtualization:        VT-x				#支持cpu虚拟化技术
L1d cache:             32K
L1i cache:             32K
L2 cache:              256K
L3 cache:              20480K
NUMA node0 CPU(s):     0-31


上面这台服务器的CPU配置是2个socket，每个socket是8个core，每个core是超线程2,这样，整台机器的对外的core就是2*8*2=32
总核数 = 物理CPU个数 X 每颗物理CPU的核数 
总逻辑CPU数 = 物理CPU个数 X 每颗物理CPU的核数 X 超线程数
```

查看/proc/cpuinfo,可以知道每个cpu信息，如每个CPU的型号，主频等。

```
processor	: 0
vendor_id	: GenuineIntel
cpu family	: 6
model		: 63
model name	: Intel(R) Xeon(R) CPU E5-2630 v3 @ 2.40GHz
stepping	: 2
microcode	: 56
cpu MHz		: 2394.439
cache size	: 20480 KB
physical id	: 0
siblings	: 16
core id		: 0
cpu cores	: 8
apicid		: 0
initial apicid	: 0
fpu		: yes
fpu_exception	: yes
cpuid level	: 15
wp		: yes
flags		: fpu vme de pse tsc msr pae mce cx8 apic sep mtrr pge mca cmov pat pse36 clflush dts acpi mmx fxsr sse sse2 ss ht tm pbe syscall nx pdpe1gb rdtscp lm constant_tsc arch_perfmon pebs bts rep_good xtopology nonstop_tsc aperfmperf pni pclmulqdq dtes64 ds_cpl vmx smx est tm2 ssse3 fma cx16 xtpr pdcm pcid dca sse4_1 sse4_2 x2apic movbe popcnt tsc_deadline_timer aes xsave avx f16c rdrand lahf_lm abm ida arat epb xsaveopt pln pts dts tpr_shadow vnmi flexpriority ept vpid fsgsbase bmi1 avx2 smep bmi2 erms invpcid
bogomips	: 4788.87
clflush size	: 64
cache_alignment	: 64
address sizes	: 46 bits physical, 48 bits virtual
power management:
```

#### 内存

概要查看内存情况free -m

```
free -m
             total       used       free     shared    buffers     cached
Mem:         64024      62110       1914        161       2140      38078
-/+ buffers/cache:      21891      42133
Swap:        31999          0      31999

这里的单位是MB，总共的内存是64024MB
```

#### 硬盘

查看硬盘和分区分布:lsblk

```
NAME   MAJ:MIN RM  SIZE RO TYPE MOUNTPOINT
sda      8:0    0  2.7T  0 disk
├─sda1   8:1    0    1G  0 part /boot
├─sda2   8:2    0 62.5G  0 part /
├─sda3   8:3    0 31.3G  0 part [SWAP]
└─sda4   8:4    0  2.6T  0 part /opt

fdisk -l

Disk /dev/vda: 214.7 GB, 214748364800 bytes  #硬盘
16 heads, 63 sectors/track, 416101 cylinders
Units = cylinders of 1008 * 512 = 516096 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0x0006da2f

   Device Boot      Start         End      Blocks   Id  System
/dev/vda1   *           3         409      204800   83  Linux
Partition 1 does not end on cylinder boundary.   #分区1
/dev/vda2             409      416102   209509376   83  Linux
Partition 2 does not end on cylinder boundary.   #分区2
```

#### 网卡

```
lspci | grep -i 'eth'
09:00.0 Ethernet controller: Intel Corporation I350 Gigabit Network Connection (rev 01)  
09:00.1 Ethernet controller: Intel Corporation I350 Gigabit Network Connection (rev 01) 

cat /sys/class/net/eth0/speed  #查看网卡带宽 1000
netstat -lntp				#查看所有监听端口
netstat -antp			  	#查看所有已经建立的连接
netstat -s 					#查看网络统计信息
route -n               		# 查看路由表
netstat -an | grep ESTABLISHED | wc -l  #查看并发访问数
ifconfig               		# 查看所有网络接口的属性
netstat -an | grep :3306    #查看3306端口的是否已在使用中，可验证使用该端口的服务是否已正常运行
netstat -nat| grep -i "80" | wc -l  #返回所有80端口的请求总数
lsof -i：[port number]  		#列出谁在使用某个端口
lsof -i :3306 			     #查看3306端口被什么程序占用

```
**Linux目录结构介绍**

Linux 文件系统是一个目录树的结构，文件系统结构从一个根目录开始，根目录下可以有任意多个文件和子目录，子目录中又可以有任意多个文件和子目录

- bin 存放二进制可执行文件(ls,cat,mkdir等)
- boot 存放用于系统引导时使用的各种文件
- dev 用于存放设备文件
- etc 存放系统配置文件
- home 存放所有用户文件的根目录
- lib 存放跟文件系统中的程序运行所需要的共享库及内核模块
- mnt 系统管理员安装临时文件系统的安装点
- **opt 额外安装的可选应用程序包所放置的位置**
- proc 虚拟文件系统，存放当前内存的映射
- root 超级用户目录
- sbin 存放二进制可执行文件，只有root才能访问
- tmp 用于存放各种临时文件
- usr 用于存放系统应用程序，比较重要的目录/usr/local 本地管理员软件安装目录
- var 用于存放运行时需要改变数据的文件