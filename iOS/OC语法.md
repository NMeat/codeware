#1.OC中的特殊语法#

category：分类 *在不修改原类基础上对类进行扩展*

比如:
	已经有一个Person类 可以创建一个分类
	
例如: `Person+blackPerson`

* 分类可以扩展原类,而且可以重写父类的方法
* 当一个类有两个及两个以上的分类时，分别都重写父类的同一个方法,首先起作用的顺序按照程序的编译顺序
* 如果要用到扩展类的功能 在实例该类的文件中 除了引入该类的类文件外 还要引入该扩展类的 .h文件


# 2.编译器指令 #
   用来告诉编译器要做什么
	
	@property:
		@property是编译器的指令 告诉编译器在@interface中自动生成setter和getter的声明
	@synthesize:
		@synthesize是编译器的指令 告诉编译器在@implementation中自动生成setter和getter的实现
# 3.类的初始化 #
1. init初始化方法（构造方法）：一般和alloc一起调用，用于给成员变量初始化
2. id类型：相当于C中的void`*`，可以指向任何对象，不能加`*`，类似.net或java中的泛型
3. 带参的初始化方法（自定义的初始化方法），是实例方法，必须以initWith开头


    	例如:
		-(id)initWithName:(NSString*)name andPrice:(float)price andPage:(int)page;

     	Book *b3=[[Book alloc]initWithName:@"iOS开发"  andPrice:100 andPage:600];

    	//重写init方法 并初始化成员变量
	     -(id)init{
		     //调用父类的方法初始化从父类中继承的成员变量
		     //super实际上是一个编译器符号，表示调用父类的方法
		     self=[super init];
	     	 if(self != nil){  
				//nil相当于c中的NULL，如果父类初始化成功，
				//才可以继续操作（实现成员变量的初始化）
			     _name=@"myBook";
			     _page=300;
			     _price=50;
	    	 }
	    	return self;//返回当前对象
	      }

# 4.UIImage的两种加载方式 #

	    1.有缓存：读取后放入缓存中下次可直接读取，适用于图片较少且频繁使用
	    [UIImage imageNamed:@"文件名"]；

	    2.无缓存：用完就释放掉，参数传的是全路径，适用于图片较多的情况下。
	    [UIImage alloc] initWithContentsOfFile:@"文件全路径"];