<?php
//原则上是一张表对应一个模型
class AdminModel extends Model {
	protected $table = 'admin';

    //定义一个验证用户的方法
	public function checkByLogin($log_name,$login_pass){
        $sql = "select * from {$this->initTable()} where admin_name='$log_name' and admin_pass=md5('$login_pass')";
        $row = $this->db->fetchRow($sql);
        return $row;
	}

	public function checkByCookie(){
		if(!isset($_COOKIE['admin_id']) || !isset($_COOKIE['admin_pass'])){
			return false;
		}
		$sql = "select * from {$this->initTable()} where admin_id = '{$_COOKIE['admin_id']}' and md5(concat('shop_admin',admin_pass,'pass')) = '{$_COOKIE['admin_pass']}'";
		return $this->db->fetchRow($sql);
	}
}