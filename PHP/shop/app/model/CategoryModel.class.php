<?php
class CategoryModel extends Model{
	protected $table = 'category';

	public function getList(){
		$sql = "select * from {$this->initTable()} where 1 order by sort_order";
		return $this->db->fetchAll($sql);
	}

	public function getTree($arr,$pare_id = 0,$deep = 0){
		static $tree = array();
		foreach($arr as $row){
			if($row['parent_id'] == $pare_id){
				$row['deep'] = $deep; //将$deep的值插入该元素
				$tree[] = $row;       //将新的数组 加入静态变量
				$this->getTree($arr,$row['cate_id'],$deep+1);
			}
		}
		return $tree;
	}

	public function getCategoryList($pare_id = 0){
		$list = $this->getList();
		return $this->getTree($list,$pare_id,0);
	}
  /**********************这是分界线**********************/

	public function deleteById($id){
		if(!$this->isLeafList($id)){
			$this->error_info="对不起，分类不是末级分类";
			return false;
		}
		return $this->autoDelete($id);
	}

	//判断该分类是不是叶子分类
	function isLeafList($id){
		$sql = "select count(*) from {$this->initTable()} where parent_id = '$id'";
		$child_count = $this->db->fetchColumn($sql);
		return $child_count == 0;
	}

   /**********************这是分界线**********************/

	function insertList($arr){
		if($arr['cate_name'] == ''){
			$this->error_info = "分类名不能为空";
			return false;
		}
		$sql = "select count(*) from {$this->initTable()} where cate_name='{$arr['cate_name']}' and parent_id='{$arr['parent_id']}'";
		if($this->db->fetchColumn($sql)){
			$this->error_info = "该分类已经存在";
			return false;
		}
		return $this->autoInsert($arr);
	}
     
    /**********************这是分界线**********************/

	function getSingleListById($id){
		return $this->autoSelectRow($id);
	}

	function updateSingleList($arr){
		$child_list = $this->getCategoryList($arr['cate_id']);
		$noIDArray = array($arr['cate_id']);
		foreach ($child_list as $row){
			$noIDArray[] = $row['cate_id'];
		}

		if(in_array($arr['parent_id'],$noIDArray)){
			$this->error_info = "不能为自己或则自己的后代";
			return false;
		}
		$sql = "update {$this->initTable()} set cate_name = '{$arr['cate_name']}',sort_order = '{$arr['sort_order']}',parent_id = '{$arr['parent_id']}' where cate_id = '{$arr['cate_id']}'";
		return $this->db->query($sql);
	}   
}