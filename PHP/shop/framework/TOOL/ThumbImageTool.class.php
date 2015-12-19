<?php
class ThumbImageTool {
     public function MkThumbImage($img_src,$max_height,$max_width){
	      if(! file_exists($img_src)){
		      $this->error_info = "对不起源文件不存在";
			  return false;
		  }

		  $img_src_info = getimagesize($img_src);
		  $img_src_width = $img_src_info[0];  //原图的高
		  $img_src_height =  $img_src_info[1];  //原图的宽

		  if($img_src_height < $max_height && $img_src_width < $max_width){
		      $dst_img_height = $img_src_height;
			  $dst_img_width = $img_src_width;
		  }else{
		      if($img_src_height/$max_height > $img_src_width/$max_width){
			      $dst_img_height = $max_height;
				  $dst_img_width = $img_src_width/$img_src_height * $max_width;
			  }else{
			      $dst_img_width = $max_width;
				  $dst_img_height = $img_src_height/$img_src_width * $max_height;
			  }
		  }

		  $src_img = imagecreatefromjpeg($img_src);
		  $dst_img = imagecreatetruecolor($max_width,$max_height);

		  $blue = imagecolorallocate($dst_img,0x0,0x0,0xff);
		  imagefill($dst_img,0,0,$blue);

		  $dst_x = ($max_width-$dst_img_width)/2;
		  $dst_y = ($max_height-$dst_img_height)/2;
                                                                                                           
		  imagecopyresampled($dst_img,$src_img,$dst_x,$dst_y,0,0,$dst_img_width,$dst_img_height,$img_src_width,$img_src_height);
		  

		  $src_dir = dirname($img_src);
		  $src_basename = basename($img_src);
		  $thumb_file = substr($src_basename,0,strrpos($src_basename,'.')).'_thumb'.strrchr($src_basename,'.');

		  imagejpeg($dst_img,$src_dir . DS . $thumb_file);

		  imagedestroy($src_img);
		  imagedestroy($dst_img);

		  return basename($src_dir)."/".$thumb_file;

	 }
}