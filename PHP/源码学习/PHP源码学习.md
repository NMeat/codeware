**PHP源码学习---START**

    在PHP中有8种数据类型:
    基本类型：String Integer Float(double) Boolean
    复合类型: Array Object
    特殊类型: Resource NULL

	变量的存储结构:
		struct _zval_struct {
		    zvalue_value value;         //存储变量的值 是个联合体
		    zend_uint refcount__gc;     //表示引用计数 默认1
		    zend_uchar type;            //变量具体的类型
		    zend_uchar is_ref__gc;      //表示是否为引用 默认0
		};
	type的值可以为： IS_NULL、IS_BOOL、IS_LONG、IS_DOUBLE、IS_STRING、IS_ARRAY、IS_OBJECT和IS_RESOURCE。

	上面的value是个联合体,所以才能实现PHP的弱类型:
	typedef union _zvalue_value {
	    long lval;         // boolean integer
	    double dval;       // float
	    struct {
	        char *val;
	        int   len;
	    } str;                  //String
	    HashTable *ht;   	    //Array
	    zend_object_value obj; 	//Object
	} zvalue_value;