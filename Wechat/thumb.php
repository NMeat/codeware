<?php
/**
 *图片裁剪函数
 *@param  $img    String -图片路径
 *        $width  Int    -裁剪宽度
 *        $height Int    -裁剪高度
 *        $id     Int    -图片的ID
 *@return void  
 */
function cutimg($img,$width,$height,$id){	
    //给定的文件名取得的图像。
    $size = getimagesize($img);
    //判断图片类型
    if ($size[2] == 1)
    {
        $src = imagecreatefromgif($img); //从路径创建图像
    }elseif($size[2] == 2){
        $src = imagecreatefromjpeg($img); 
    }else{
        $src = imagecreatefrompng($img); 
    }
    //如果图片的宽比要求的小，则以原图宽为准
    $w = $size[0]<$width?$size[0]:$width;
    $h = $size[1]<$height?$size[1]:$height;
    //创建裁剪要求尺寸大小的空白图像
    $bg = imagecreatetruecolor($w,$h);
    //宽从哪儿截取
    $jqw = $size[0]<$width ? 0 :  ($size[0] - $width)/2;
    //高从哪儿截取
    $jqh = $size[1]<$height ? 0 : ($size[1] - $height)/2;
    imagecopy($bg,$src,0,0,$jqw,$jqh,$w,$h);
    imagejpeg($bg,"/img/wechat/thumb_".$id.".jpg");
    imagedestroy($bg);//销毁资源
}
/**
 * 缩略图函数
 *@param    $path String - 图片路径
 *          $id   Mixed  - 图片ID
 *@return         String - 缩略图路径
 */
function thumbPic($path,$id){
    $imgSize  = getimagesize($path);//图片size
    $width    = $imgSize[0];//原图片宽
    $height   = $imgSize[1];//原图片高
    if($width < $height)//比较宽高大小
    {
        $scale     = round($width/300, 1);//缩放比例
        $newWidth  = 300; 
        $newHeight = round($height/$scale, 1); 
    }else{
        $scale     = round($height/300, 1);//缩放比列
        $newHeight = 300; 
        $newWidth  = round($width/$scale, 1);
    }
    $dst_img   = imagecreatetruecolor($newWidth, $newHeight);//创建画布
    $src_img   = imagecreatefromjpeg($path);//从路径创建图像
    imagecopyresampled($dst_img,$src_img,0,0,0,0,$newWidth,$newHeight,$width,$height);//重采样拷贝部分图像并调整大小
    imagejpeg($dst_img,"/img/wechat/tmp_".$id.".jpg");//创建图像
    imagedestroy($dst_img);
    imagedestroy($src_img);
    return "/img/wechat/tmp_".$id.".jpg";//返回缩略图路径
}
