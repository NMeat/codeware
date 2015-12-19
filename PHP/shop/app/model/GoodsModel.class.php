<?php
class GoodsModel extends Model{
    protected $table = 'goods';

    public function insertGoods($arr){
        return $this->autoInsert($arr);
    }

  /********************这是分界线******************/
    public function getGoodsList($pageNO,$pageSize){
        $pageOffset = ($pageNO-1)*$pageSize;
        $sql = "select * from {$this->initTable()} where 1 limit $pageOffset,$pageSize";
        $data['list'] = $this->db->fetchAll($sql);

        $sql = "select count(*) from {$this->initTable()} where 1";
        $data['totalPage'] = $this->db->fetchColumn($sql);
        return $data;
    }
    /********************这是分界线******************/
    public function deleteGoodsByID($id){
    return $this->autoDelete($id);
    }
}