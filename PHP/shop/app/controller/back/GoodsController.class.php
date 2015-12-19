<?php
class GoodsController extends BackPlatformController{
	public function addAction(){
		$categoryModel = new CategoryModel;
		$list = $categoryModel->getCategoryList();
		require CURRENT_VIEW_DIR . "goods_add.html";
	}
   //添加商品
   public function insertAction(){
		//搜集数据
		$data['goods_name'] = $_POST['goods_name'];
		$data['goods_sn'] = $_POST['goods_sn'];
		$data['cate_id']  =$_POST['cate_id'];
		$data['shop_price'] =$_POST['shop_price'];
		$data['market_price'] = $_POST['market_price'];
		$data['goods_stock'] = $_POST['goods_stock'];
		$data['goods_desc'] = $_POST['goods_desc'];
		//处理热卖 新品
		$is_best = isset($_POST['is_best']) ? $_POST['is_best']:0;
		$is_new = isset($_POST['is_new']) ? $_POST['is_new']:0;
		$is_hot = isset($_POST['is_hot']) ? $_POST['is_hot']:0;
		$data['goods_status'] = 0 |$is_best|$is_hot|$is_new;

		$data['is_on_sale'] = isset($_POST['is_on_sale'])? $_POST['is_on_sale']:'0';
		$data['add_time'] = time();

		$uploadtool = new UploadTool(UPLOAD_DIR,2000000);
		$uploadtool->allow_types = array('image/jpeg','image/png','image/gif');

		if($result = $uploadtool->upload($_FILES['image_ori'],'goods_')){
			$data['image_ori'] = $result;
			$thumbImageTool = new ThumbImageTool;
			$data['image_thumb'] = $thumbImageTool->MKThumbImage(UPLOAD_DIR.$result,100,100);
		}

		$goodsModel = new GoodsModel;
		if($goodsModel->insertGoods($data)){
			$this->jump('index.php?p=back&c=Goods&a=list');
		}else{
			$this->jump('index.php?p=back&c=Goods&a=add','添加失败，请重新添加',2);
		}
   }

   /**************************这是分界线*******************************/

	public function listAction(){ 
		$pageNO   = isset($_GET['pageNO']) ? $_GET['pageNO'] : 1;
		$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : $GLOBALS['config']['back']['goods_page_size'];

		$goodsModel = new GoodsModel;
		$result = $goodsModel->getGoodsList($pageNO,$pageSize);
		$list   = $result['list'];
		$totalPage     = ceil($result['totalPage']/$pageSize);
		$quickPageTool = new QuickPageTool;
		$page_html = $quickPageTool->showQuickPage($pageNO,$pageSize,$result['totalPage'],"index.php?p=back&c=Goods&a=list",array("pageSize"=>$pageSize));
		require CURRENT_VIEW_DIR . 'goods_list.html';
	}

   /**************************这是分界线*************************/

	public function deleteGoodsAction(){    
		$delModel = new GoodsModel;
		if($delModel->deleteGoodsByID($goodsID = $_GET['goodsID'])){
			$this->jump("index.php?p=back&c=Goods&a=list");
		}else{
			$this->jump("index.php?p=back&c=Goods&c=list","删除失败",2);
		}
	}
}