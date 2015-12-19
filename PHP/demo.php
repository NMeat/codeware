<?php
/**
 *一个创建多级目录的函数
 *@param   $path  string 要创建的目录
 *@param   $mode  int    创建目录的权限模式 window中可以忽略
 */
function create_dir($path, $mode = 0777){
    if(is_dir($path)){
        echo "该目录已经存在";
    }else{
        if(mkdir($path, $mode, true)){
            echo "创建成功";
        }else{
            echo "创建失败";
        }
    }
}

/**
 *确保多个进程同时写入同一个文件时能成功
 *@ param  $file  string 文件名
 *@ param  $text  string 写入内容
 *@ param  $mode  string 写入模式
 *
 */
function writeFile($file,$text,$mode="w+"){
    $fop = fopen($file, $mode);
    if(flock($fop, LOCK_EX)){ //给文件加锁
        fwrite($fop,$text);
        flock($fop, LOCK_UN); //释放文件锁
    }else{
        echo "file is locking";
    }
    fclose($fop);//关闭资源
}

/**
 *从一个标准的url里取出文件的扩展名
 *@param    $url   string  url地址
 *@return   扩展名
 */
function getExt($url){
    //解析URL
    $arr = parse_url($url);
    //获取文件名
    $file = basename($arr["path"]);
    //用点号分割字符串
    $ext  = explode(".", $file);
    return $ext[count($ext) - 1];    
}
//$url = "http://www.baidu.com/aa/bb/cc.php?aa=dd&&cc=dd#dfa";
//echo getExt($url);

/**
 *取出一个目录下的所有文件和子文件
 *@param  $dir      string  目录名
 *@return $files    array   文件名和目录名
 */
function my_scandir($dir){
    $files = array();
    if(is_dir($dir)){ //是否是一个目录
        //打开一个目录句柄资源
        if($handle = opendir($dir)){
            while(($file = readdir($handle)) !== false){    //返回目录中下一个文件的文件名
                if($file != "." && $file != "..") { //不等于特殊文件
                    if(is_dir($dir . "/" .$file)){
                        $files[$file] = my_scandir($dir . "/" . $file);
                    }else{
                        $files[] = $dir . "/" . $file; //把
                    }
                }
            }
        }
        closedir($handle);
        return $files;
    }
}

//$dir = "/home/lzf/github/alpha/java";
//print_r(my_scandir($dir));

/*
 * 判断一个字符串是否是合法的日期格式:2015-04-04 12:34:54
 *
 *@param  $timeStr  string  时间字符串
 *@return boolean 
 */
function checkDateTime($timeStr){
    if(date("Y-m-d H:i:s", strtotime($timeStr)) == $timeStr){
        return true;
    }else{
        return false;
    }
}
//$timeStr = "2015-04-09 13:34:21";
//echo checkDateTime($timeStr);

/**
 *返回上个月的最后一天
 *@param  $date  string  给定的日期
 * 
 */
function getLastMonthLastDay($date){
    if($date != ""){
        $time = strtotime($date);
    }else{
        $time = time();
    }
    $day = date("j", $time); //获取当前日期是当前月的第几天
    return date("Y-m-d", strtotime("-{$day} days", $time));
}
/**
 *获取一个路径相对于另一个另一个路径的相对路径
 *@param $a string 路径1
 *@param $b string 路径2
 *
 *@return string
 */
function getRelativePath($a,$b){
    $a2array = explode("/", $a);
    $b2array = explode("/", $b);
    $relativePath = array();
    for($i = 1; $i <= count($b2array) - 2; $i++){
        $relativePath[] = $a2array[$i] == $b2array[$i] ? ".." : $b2array[$i];
    }
    return implode("/",$relativePath);//把数组转换成字符串
}

$tmp =  getRelativePath("/a/b/c/d/e.php", "/a/b/13/14/c.php");
print_r($tmp);

/**
 *截取字符串
 *@param    -string   $str      要处理的字符串
 *          -int      $start    开始位置
 *          -int      $end      结束位置
 *          -string   $charset  字符集编码
 *          -string   $suffix   后缀
 *@return   -string   $str      处理过的字符串
 */
function substr_ext($str, $start=0, $end, $charset="utf-8", $suffix="..."){
    if(function_exists("mb_substr")){
        return mb_substr($str, $start, $end, $charset).$suffix;
    }elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$end,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

/**
 *php实现下载远程图片到本地
 *@param $url       string      远程文件地址
 *@param $filename  string      保存后的文件名（为空时则为随机生成的文件名，否则为原文件名）
 *@param $fileType  array       允许的文件类型
 *@param $dirName   string      文件保存的路径（路径其余部分根据时间系统自动生成）
 *@param $type      int         远程获取文件的方式
 *@return           json        返回文件名、文件的保存路径 例子：{'fileName':13668030896.jpg, 'saveDir':/www/test/img/2013/04/24/}
 *调用示例:getImage('http://img.wan.renren.com/images/2013/0430/1367294093164.jpg', '', '/www/test/img/', array('jpg', 'gif'));
 */
function getImage($url, $filename='', $dirName, $fileType, $type=0){
    if($url == ''){
        return false;//没有指定URL　返回false
    }
    //获取文件原文件名
    $defaultFileName = basename($url);
    //获取文件类型
    $suffix = substr(strrchr($url,'.'), 1);
    if(!in_array($suffix, $fileType)) return false; //判断文件格式是否符合要求
    
    //设置保存后的文件名
    $filename = $filename == '' ? time().rand(0,9) . '.' .$suffix : $defaultFileName;
    //获取远程文件资源
    if($type){
        $ch = curl_init();
        $timeout = 5; //发起连接前的等待时间
        curl_setopt($ch, CURLOPT_URL, $url);//设置获取图片的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file = curl_exec($ch);
        curl_close($ch);
    }else{
        ob_start();
        readfile($url);//读入一个文件　并写入缓冲区
        $file = ob_get_contents();//返回缓冲区的内容
        ob_end_clean();//清除缓冲区的内容
    }
    //设置文件保存路径
    $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
    if(!file_exists($dirName)){
        mkdir($dirName, 0777, true);
    }
    //保存文件
    $res = fopen($dirName.$filename,'a');//写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之
    fwrite($res,$file);//函数写入文件（可安全用于二进制文件)
    fclose($res);//关闭打开文件
    return "{'fileName':$filename, 'saveDir':$dirName}";//返回值
}
echo getImage("http://www.baidu.com/img/bdlogo.png", "test", "/home/local/lzf", array("png"));

//对二维数组按照某个键值进行排序
function testSort($arr, $str, $order = 0){
    $tmpArr = array();
    foreach ($arr as $key => $value){
        $keyTest = $value[$str];
        $tmpArr[$keyTest] = $value;
    }
    if($order == 0){
        ksort($tmpArr); //根据键词对数组排序
    }else{
        krsort($tmpArr);//根据键值对数组逆向排序
    }
    return $tmpArr = array_values($tmpArr);
}

$arr = array(
    array("name"=>"lzf1", "score"=>78),
    array("name"=>"lzf2", "score"=>58),
    array("name"=>"lzf3", "score"=>98),
    array("name"=>"lzf4", "score"=>28)
);

//$arrT = testSort($arr, "score", 1);
//var_dump($arrT);

//在一个数组中查找指定的值
function seqSearch($arr, $target){
    for($i = 0, $length = count($arr); $i < $length; $i++){
        if($arr[$i] == $target){
            break;//找到就跳出遍历
        }
    }
    return $i < $length ? $i : -1;
}

//二分查找法
$arr = array(4,6,7,9,3,2);
function binSearch($arr, $start, $end, $target){
    if($start <= $end){
        $mid = intval(($start+$end)/2);
        if($arr[$mid] == $target){
            return $mid;
        }elseif($target < $arr[$mid]){
            return binSearch($arr, $start, $mid-1, $target);
        }else{
            return binSearch($arr, $mid+1, $end, $target);
        }
    }
    return -1;
}
sort($arr);
var_dump(binSearch($arr,0,5,2));

/*
 *利用递归 实现无限级分类
 *@author  liuzhifeng
 *@date    2014-12-29
 */

//预制一个数组
$rows = array(
    array('id' => 1,'name' => 'dev',   'parent_id' => 0),
    array('id' => 2,'name' => 'php',   'parent_id' => 1),
    array('id' => 3,'name' => 'smarty','parent_id' => 2),
    array('id' => 4,'name' => 'life',  'parent_id' => 0),
    array('id' => 5,'name' => 'pdo',   'parent_id' => 2),
    array('id' => 6,'name' => 'pdo-mysql','parent_id' => 5),
    array('id' => 7,'name' => 'java',  'parent_id' => 1)
);


/*
 *@param  $arr       -array,    要处理的数组 
 *        $pare_id   -int,      父结点的ID ，默认值是0
 *        $deep,     -int,      子结点的深度，默认值是0
 *
 *@return array      -array     返回处理后的数组树
 */
function getTree($arr,$pare_id = 0, $deep = 0){
    static $tree = array();                          //定义一个静态数组变量
    foreach($arr as $value){
        if ($value['parent_id'] == $pare_id) {
            $value['deep'] = $deep;                  //将树的深度值插入该元素
            $tree[] = $value;                        //再将改变后的数组放入静态数组里
            getTree($arr, $value['id'], $deep + 1);
        }
    } 
    return $tree;                                    //返回处理后的数组树
}

$tree = getTree($rows);
var_dump($tree);

/**     
 *      PHP位运算
 *      $a & $b   And（按位与）       将把 $a 和 $b 中都为 1 的位设为 1。
 *      $a | $b   Or（按位或）        将把 $a 和 $b 中任何一个为 1 的位设为 1。
 *      $a ^ $b   Xor（按位异或）     将把 $a 和 $b 中一个为 1 另一个为 0 的位设为 1。
 *      ~ $a      Not（按位取反）     将 $a 中为 0 的位设为 1，反之亦然。
 *      $a << $b  Shift left（左移）  将 $a 中的位向左移动 $b 次（每一次移动都表示“乘以 2”）
 *      $a >> $b  Shift right（右移） 将 $a 中的位向右移动 $b 次（每一次移动都表示“除以 2”）
 *
 *
 *
 * 1、权限应用
 * 拥有哪些权限，就把这些权限对应的数值加起来
 * 例如：版主拥有权限（增加、删除、修改、查询），则版主的权限值存储为15（8+4+2+1）
 * 然后【权限值之和】 与 【实际权限值】做【位于】比较
 * 结果是真则拥有权限
 * 结果是假则没有权限
 * 
 * 注意：权限值必须是2的N次方，从0次方开始，31次方是2147483648
 * 32次方是4294967296，已超过了常用int(10)最大存储4294967295，所以必须注意权限数量（<31个）
 * 当然如果存储格式为bitint或varchar等可以存储更长数字的格式，那么权限数量可以继续增加
 */
$permission  = 15;  //1+2+4+8 拥有全部权限 表示这个人拥有的所有权限
$permissions = array(8 => '增加',4 => '删除',2 => '修改',1 => '查询');
foreach ($permissions as $key => $val) {
    if($key & $permission) {    //判断8 4 2 1是否在 15以内
        echo '我有' . $val . '的权力<br>';
    }
}