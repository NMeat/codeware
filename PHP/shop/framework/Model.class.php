<?php
/**
 *模型的基类
 *
 */
class Model{

	protected $db;      //声明一个变量 来保存数据库连接
	protected $prefix;  //一个表前缀变量
	protected $fields;  //保存一个数组 

	public function __construct(){
		$this->prefix = $GLOBALS['config']['database']['prefix'];
		$this->initLink();
		$this->fields_desc();
	}

	protected function initLink(){
		//不用实例化就能访问一个类的静态方法
		$this->db = MySQLDB::getInstance($GLOBALS['config']['database']);
	}
	
	public function initTable(){
	    return $this->prefix.$this->table;
	}

	public function fields_desc(){
	    $sql = "desc {$this->initTable()}";
		$fields_desc = $this->db->fetchAll($sql);
		foreach($fields_desc as $row){
		    $this->fields[] = $row['Field'];
			if($row['Key'] == 'PRI'){
			   $this->fields['pk'] = $row['Field'];
			}
		}
	}

    //根据 主键值 自动删除
	public function autoDelete($pk_value){
	    $sql = "delete from {$this->initTable()} where {$this->fields['pk']} = '{$pk_value}'";
		return $this->db->query($sql);
	}

    //根据 主键值 自动查询一条记录
	public function autoSelectRow($pk_value){
	   $sql = "select * from {$this->initTable()} where {$this->fields['pk']} = '{$pk_value}'";
	   return $this->db->fetchRow($sql);
	}

	//根据 主键值 自动插入
	public function autoInsert($arr){
	  $sql = "insert into {$this->initTable()} ";
	  $fields = array_keys($arr);   //array_keys()返回数组中的键名  返回值是一个数组
	  $fields_str  = implode(',',$fields); //implode()将一个一维数组 转化成一个字符串
	  $sql .= '(' . $fields_str . ')';
	  $values = array_map(function ($v){return "'" . $v . "'";},$arr);
	  $values_str = implode(',',$values);
	  $sql .= ' values (' . $values_str . ')';
      return $this->db->query($sql);
	}
}