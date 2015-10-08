<?php
/**
 *分类页
 *@author   liuzhifeng
 *@date     2015-07-27
 */

 class PageBar
 {
    private $totalRow;          //总条数
    private $totalPage;         //总页数
    private $listRow = 5;       //分页栏显示多少页
    private $pageSize = 20;     //每页显示多少条记录
    private $page;              //第几页
    private $url;
    private $html;              //分页代码字符串
    //分页bar默认显示5页  每次显示20条记录
    function __construct($totalRow, $param, $currPage,$pageSize)
    {
        $this->totalRow  = intval($totalRow);
        $this->pageSize  = $pageSize ? intval($pageSize): $this->pageSize ; 
        $this->totalPage = ceil($this->totalRow / $this->pageSize);//总页数
        $this->page      = $this->setPage($currPage);//获取当前页
        $this->url       = $param;
    }
    /**
     *@param int      $page  当前页
     *       string   $param 参数
     */
    public function makeBar($page, $param)
    {
        if($this->totalRow == 0) return '暂无记录';
        $this->html = $this->getFirstPage();
        $this->html .= $this->getPrevPage();
        $this->html .= $this->getPageList();
        $this->html .= $this->getNextPage();
        $this->html .= $this->getLastPage();
        $this->html .= $this->getTotalPage();
        return $this->html;
    }

    //获取当前页码
    private function setPage($currPage)
    {
        if(!empty($currPage)){ //是否为空
            if($currPage > 0){  //是否大于0
                if($currPage > $this->totalPage){
                    return $this->totalPage;
                }else{
                    return $currPage;
                }
            }else{
                return 1;
            }
        }else{
            return 1;
        }
    }
    //分页list
    private function getPageList()
    {
        $fir = $this->page % $this->listRow;
        if($fir)
            $fir = $this->page - $fir + 1;
        else
            $fir = $this->page - 5 + 1;
        $tmp = '';
        for($i = $fir; $i < $fir + 5; $i++)
        {
            if($i <= $this->totalPage){
                if($this->page == $i) 
                {
                    $class = 'current';
                    $tmp .= '<a target="_self" class="current">'. $i .'</a>';
                }else{
                    $tmp .= '<a target="_self" href='. $this->url. $i .'.html>'. $i.'</a>';
                }
                
            }
            else{
                break;
            }
        }
        return $tmp;
    }

    //首页
    private function getFirstPage()
    {
        if($this->page == 1){
            return '';
        }else{
            return '<a target="_self" title="首页" href=' . $this->url . '1.html >首页</a>';
        }
    }

    //上一页
    private function getPrevPage()
    {
        if($this->page == 1){
            return '';
        }else{
            return '<a target="_self" title="上一页" href=' . $this->url . ($this->page - 1).'.html >上一页</a>';
        }
    }
    //下一页
    private function getNextPage()
    {
        if($this->page == $this->totalPage)
        {
            return '';
        }else{
            return '<a target="_self" title="下一页" href=' . $this->url . ($this->page + 1).'.html >下一页</a>';
        }
    }
    //尾页
    private function getLastPage()
    {
        if($this->page == 1 && $this->page == $this->totalPage){
            return '';
        }else{
            return '<a target="_self" title="尾页" href=' . $this->url . ($this->totalPage).'.html >尾页</a>';
        }
    }
    //总页数
    private function getTotalPage()
    {
        return '<a target="_self" class="last">共'.$this->totalPage.'页</a>';
    }
}