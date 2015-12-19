<?php
class CategoryController extends BackPlatformController{
	function ListAction(){
		$categoryModel = new CategoryModel();
		$list = $categoryModel->getCategoryList();
		require CURRENT_VIEW_DIR."category_list.html";
	}
   
	//删除分类
	function deleteByIdAction(){
		$categoryModel = new CategoryModel();
		if($categoryModel->deleteById($_GET['id'])){
			$this->jump('index.php?p=back&c=Category&a=list');
		}else{
			$this->jump('index.php?p=back&c=Category&a=list','失败'.$categoryModel->error_info);
		}
	}

	/****************************这是分界线************************************/

	//增加分类
	function addListAction(){
		$categoryModel = new CategoryModel();
		$cate_list = $categoryModel->getCategoryList();
		require CURRENT_VIEW_DIR . 'category_add.html';
	}
   
	//插入分类
	function insertAction(){
		$data['cate_name']  = $_POST['cat_name'];
		$data['parent_id']  = $_POST['parent_id'];
		$data['sort_order'] = $_POST['sort_order'];

		$categoryModel = new CategoryModel();
		if($categoryModel->insertList($data)){
			$this->jump("index.php?p=back&c=Category&a=list");
		}else{
			$this->jump("index.php?p=back&c=Category&a=addlist",$categoryModel->error_info);
		}
	}

   /****************************这是分界线************************************/

	//编辑分类
	function editAction(){
		$categoryModel = new CategoryModel();
		$curr_list = $categoryModel->getSingleListById($_GET['id']);
		$cate_list = $categoryModel->getCategoryList();
		require CURRENT_VIEW_DIR . "category_edit.html";   
	}

	//更新分类
	function updateAction(){
		$data['cate_id']   = $_POST['cate_id'];
		$data['cate_name'] = $_POST['cate_name'];
		$data['sort_order']= $_POST['sort_order'];
		$data['parent_id'] = $_POST['parent_id'];
		$categoryModel = new CategoryModel();
		if($categoryModel->updateSingleList($data)){
			$this->jump("index.php?p=back&c=Category&a=list");
		}else{
			$this->jump("index.php?p=back&c=Category&a=edit&id=".$data['cate_id'],$categoryModel->error_info,2);
		}
	}
}