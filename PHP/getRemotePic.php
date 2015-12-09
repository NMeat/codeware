<?php
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
function getImage($url, $filename='', $dirName, $fileType, $type=0)
{
    if($url == '')
    {
        return false;//没有指定URL　返回false
    }
    //获取文件原文件名
    $defaultFileName = basename($url);
    //获取文件类型
    $suffix = substr(strrchr($url,'.'), 1);
    if(!in_array($suffix, $fileType))//判断文件格式是否符合要求
    {
        return false;
    }
    //设置保存后的文件名
    $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;
    //获取远程文件资源
    if($type)
    {
        $ch = curl_init();
        $timeout = 5; //发起连接前的等待时间
        curl_setopt($ch, CURLOPT_URL, $url);//设置获取图片的URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file = curl_exec($ch);
        curl_close($ch);
    }
    else
    {
        ob_start();
        readfile($url);//读入一个文件　并写入缓冲区
        $file = ob_get_contents();//返回缓冲区的内容
        ob_end_clean();//清除缓冲区的内容
    }
    //设置文件保存路径
    $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
    if(!file_exists($dirName))
    {
        mkdir($dirName, 0777, true);
    }
    //保存文件
    $res = fopen($dirName.$filename,'a');//写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之
    fwrite($res,$file);//函数写入文件（可安全用于二进制文件)
    fclose($res);//关闭打开文件
    return "{'fileName':$filename, 'saveDir':$dirName}";//返回值
}
echo getImage("http://www.baidu.com/img/bdlogo.png", "test", "/home/local/lzf", array("png"));
