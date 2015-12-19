<?php
class QuickPageTool{
   function showQuickPage($pageNO,$pageSize,$total,$url,$params=array()){
      $totalPage = ceil($total/$pageSize);
	  //处理url
	  $url_info = parse_url($url);
	  if(isset($url_info['query'])){
		  $url .= '&';
	  }else{
	      $url .= '?';
	  }

	  foreach ($params as $key => $value){
	      $url .= $key ."=" . $value."&";
	  }

	  $url .= "&pageNO=";
	  //下面重点用到替代语法
      $info = <<<HTML
		  总计<span id="totalRecords">$total</span>个记录
		  分为<span id="totalPages">$totalPage</span>页
		  当前第<span id="pageCurrent">$pageNO</span>页
		  每页<input type="text" value="$pageSize" onblur="window.location.href='$url'+'1'+'&pageSize='+this.value" size=3 />条
HTML;

	  $prev = $pageNO==1?$totalPage:($pageNO-1);
	  $next = $pageNO==$totalPage?1:($pageNO+1);
	  $link =<<<HTML
		  <a href="{$url}1">第一页</a>
		  <a href="{$url}{$prev}">前一页</a>
		  <a href="{$url}{$next}">后一页</a>
		  <a href="{$url}{$totalPage}">最末页</a>
HTML;
	  $options = <<<HTML
	  <select onchange="window.location.href='$url'+this.value+'&pageSize=$pageSize'" />
HTML;
	  for($i=1;$i<=$totalPage;$i++){
	      if($i == $pageNO){
		     $options .= <<<HTML
				 <option value = "$i" selected = "selected">$i</options>
HTML;
		  }else{
		     $options .= <<<HTML
				 <option value = "$i">$i</option>
HTML;
		  }
	  }

	  $options .= '</select>';
	  return $info . '<span id="pageLink">' . $link . $options . '</span>';

   }
}