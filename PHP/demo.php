<?php
/**
 *一个创建多级目录的函数
 *@param   $path  string 要创建的目录
 *@param   $mode  int    创建目录的权限模式 window中可以忽略
 */
function create_dir($path, $mode = 0777)
{
    if(is_dir($path))
    {
        echo "该目录已经存在";
    }
    else
    {
        if(mkdir($path,$mode,true))
        {
            echo "创建成功";
        }
        else
        {
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
function writeFile($file,$text,$mode="w+")
{
    $fop = fopen($file, $mode);
    if(flock($fop, LOCK_EX))
    {
        //write something
        fwrite($fop,$text);
        flock($fop, LOCK_UN);
    }
    else
    {
        echo "file is locking";
    }
    fclose($fop);//关闭资源
}

/**
 *从一个标准的url里取出文件的扩展名
 *@param  $url   string  url地址
 *@return   扩展名
 */
function getExt($url)
{
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
function my_scandir($dir)
{
    $files = array();
    if(is_dir($dir))
    {
        //打开一个目录句柄资源
        if($handle = opendir($dir))
        {
            while(($file = readdir($handle)) !== false)
            {
                if($file != "." && $file != "..")
                {
                    if(is_dir($dir . "/" .$file))
                    {
                        $files[$file]=my_scandir($dir . "/" . $file);
                    }
                    else
                    {
                        $files[] = $dir . "/" . $file;
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
function checkDateTime($timeStr)
{
    if(date("Y-m-d H:i:s", strtotime($timeStr)) == $timeStr)
    {
        return true;
    }
    else
    {
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
function getLastMonthLastDay($date)
{
    if($date != "")
    {
        $time = strtotime($date);
    }
    else
    {
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
function getRelativePath($a,$b)
{
    $a2array = explode("/", $a);
    $b2array = explode("/", $b);
    $relativePath = array();
    for($i = 1; $i <= count($b2array) - 2; $i++)
    {
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
function substr_ext($str, $start=0, $end, $charset="utf-8", $suffix="...")
{
    if(function_exists("mb_substr"))
    {
        return mb_substr($str, $start, $end, $charset).$suffix;
    }
    elseif(function_exists('iconv_substr'))
    {
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