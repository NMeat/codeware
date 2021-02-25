# Maven概览

> 最近有个有项目上要用到`java`，学习了一个`java`工程构建、依赖管理工具Maven。它基于项目对象模型`POM`概念，利用一个中央信息片断管理一个项目的构建、报告和文档等步骤。

## 约定配置
| 目录 | 作用|
|---|---|
|${basedir} | 	存放pom.xml和所有的子目录 |
|${basedir}/src/main/java|	项目的java源代码|
|${basedir} | 	存放pom.xml和所有的子目录 |
|${basedir}/src/main/resources|	项目的资源，比如说property文件，springmvc.xml|
|${basedir}/src/test/java | 项目的测试类，比如说Junit代码 |
|${basedir}/src/test/resources|	测试用的资源|
|${basedir}/src/main/webapp/WEB-INF | 	web应用文件目录，web项目的信息，比如存放web.xml、本地图片、jsp视图页面 |
|${basedir}/target|	打包输出目录|
|${basedir}/target/classes | 编译输出目录 |
|${basedir}/src/main/java|	项目的java源代码|
|${basedir}/target/test-classes | 测试编译输出目录 |
|Test.java|	Maven只会自动运行符合该命名规则的测试类|
|~/.m2/repository | Maven默认的本地仓库目录位置 |

## Maven BOM
> 是一个XML文件，包含项目的基本信息，用于描述如何构建，声明项目依赖等  
> - `groupId`类似于`Java`的包名，通常是公司或组织名称  
> - `artifactId`类似于`Java`的类名，通常是项目名称  
> - `version` 版本号，只有以`-SNAPSHOT`结尾的版本号会被`Maven`视为开发版本  
> - `scope` 依赖关系，有 compile，test，runtime，provided
>   - compile：编译时需要用到该jar包（默认，也是最常用的），如commons-logging
>   - test：编译Test时需要用到该jar包，如junit
>   - runtime：编译时不需要，但运行时需要用到，如mysql  
>   - provided：编译时需要用到，但运行时由JDK或某个服务器提供，如servlet-api

## Maven 仓库
> Maven仓库是项目中依赖的第三方库，有本地库，中央仓库，私有仓库  
> Maven中任何一个依赖、插件或则项目构建的输出，可以称为构件  
> Maven帮助我们管理构件（主要是Jar），它是放置所有JAR文件的地方

## Maven依赖搜索顺序
1. 在本地仓库中搜索，如果找不到，执行2，如果找到了则执行其他操作。
2. 在中央仓库中搜索，如果找不到，并且有一个或多个远程仓库已经设置，则执行步骤 4，如果找到了则下载到本地仓库中以备将来引用。
3. 如果远程仓库没有被设置，Maven 将简单的停滞处理并抛出错误（无法找到依赖的文件）
4. 在一个或多个远程仓库中搜索依赖的文件，如果找到则下载到本地仓库以备将来引用，否则 Maven 将停止处理并抛出错误（无法找到依赖的文件）。

### 设置阿里云中央仓库
在`$HOME/.m2/setting.xml`中添加如下内容
```
<mirrors>
    <mirror>
        <id>aliyunmaven</id>
        <mirrorOf>central</mirrorOf>
        <name>aliyun</name>
        <url>https://maven.aliyun.com/repository/public</url>
    </mirror>
</mirrors>
```



