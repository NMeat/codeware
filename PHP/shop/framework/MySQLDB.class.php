<?php
/**
 *  mysql数据操作类
 *@author      liuzhifeng
 *@date        2014-12-28
 */
class MySQLDB {
	//属性
	//对象的初始化属性
	private $host;           //主机地址
	private $port;           //端口号
	private $user;           //用户名
	private $pass;           //密码
	private $charset;        //编码字符集
	private $dbname;         //数据库名

	//运行时生成的属性
	private $link;
	private $last_sql;         //最后执行的SQL

	private static $instance;  //当前的实例对象

	/**
	 * 构造方法
	 * @access private
	 *
	 * @param $params array 对象的选项
	 */
	private function __construct($params = array()) {
		
		//初始化 属性
		$this->host = isset($params['host']) ? $params['host'] : '127.0.0.1';
		$this->port = isset($params['port']) ? $params['port'] : '3306';
		$this->user = isset($params['user']) ? $params['user'] : 'root';
		$this->pass = isset($params['pass']) ? $params['pass'] : '';
		$this->charset = isset($params['charset']) ? $params['charset'] : 'utf8';
		$this->dbname  = isset($params['dbname']) ? $params['dbname'] : '';

		//连接数据库
		$this->connect();
		//设置字符集
		$this->setCharset();
		//设置默认数据库
		$this->selectDB();
		
	}
	/**
	 * 克隆
	 * @access private
	 */
	private function __clone() {
	}
	/**
	 * 获得单例对象
	 */
	public static function getInstance($params) {
		if (! (self::$instance instanceof self) ) {
			//实例化时，需要将参数传递到构造方法内
			self::$instance = new self($params);
		}
		return self::$instance;
	}

	/**
	 * 连接数据库
	 */
	private function connect() {
		if(!$link = mysqli_connect("$this->host:$this->port", $this->user, $this->pass)) {//$this->host . ':' . $this->port
			echo '连接失败，请检查mysql服务器，与用户信息';
			die;
		} else {
			//连接成功，记录连接资源
			$this->link = $link;
		}
	}

	/**
	 * 设置字符集
	 */
	private function setCharset() {
		$sql = "set names $this->charset";
		return $this->query($sql);
	}

	/**
	 * 设置默认数据库
	 */
	private function selectDB() {
		//判断是否存在一个数据库名
		if($this->dbname === '') {
			return ;
		}

		$sql = "use `$this->dbname`";
		return $this->query($sql);
	}

	/**
	 * 执行SQL的方法,PHPDocumentor
	 *
	 * @param $sql string 待执行的SQL
	 *
	 * @return mixed 成功返回 资源 或者 true，失败，返回false
	 */
	public function query($sql) {
		$this->last_sql = $sql;
		//执行，并返回结果
		if(!$result = mysqli_query($this->link,$sql)) {
			echo 'SQL执行失败<br>';
			echo '出错了SQL是：', $sql, '<br>';
			echo '错误代码是：', mysqli_errno($this->link), '<br>';
			echo '错误信息是：', mysqli_error($this->link), '<br>';
			die;
			return false;//象征性的！
		} else {
			return $result;
		}
	}

	/**
	 * @param $sql string 待执行的sql
	 * @return array 二维
	 */
	public function fetchAll($sql) {
		//执行
		if ($result = $this->query($sql)) {
			//成功
			//遍历所有数据，形成一个二维数组
			$rows = array();//初始化
			while($row = mysqli_fetch_assoc($result)) {
				$rows[] = $row;
			}
			//释放结果集
			mysqli_free_result($result);
			return $rows;	
		} else {
			//执行失败
			return false;
		}
	}

	/**
	 * 执行SQL，获得符合条件的第一条记录
	 *
	 * @param $sql string 待执行的SQL
	 *
	 * @return array 一维数组
	 */
	public function fetchRow($sql) {
		if ($result = $this->query($sql)) {
			$row = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			return $row;
		} else {
			return false;
		}
	}

	/**
	 * 利用一个SQL，返回符合条件的第一条记录的第一个字段的值
	 *
	 * @param $sql string 待执行的SQL
	 *
	 * @return string 执行结果
	 */
	public function fetchColumn($sql) {
		if ($result = $this->query($sql) ) {
			if ($row = mysqli_fetch_row($result)) {//row返回的是索引数组，因此0元素，一定是第一列
				mysqli_free_result($result);
				return $row[0];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
			

	
	/**
	 * 在序列化时被调用
	 *
	 * 用于负责指明哪些属性需要被序列化
	 *
	 * @return array
	 */
	public function __sleep() {
		return array('host', 'port', 'user', 'pass', 'charset', 'dbname');
	}
	
	/**
	 * 在反序列化时调用
	 *
	 * 用于 对对象的属性进行初始化
	 */
	public function __wakeup() {
		//连接数据库
		$this->connect();
		//设置字符集
		$this->setCharset();
		//设置默认数据库
		$this->selectDB();
	}
	
}