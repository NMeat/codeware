<?php
/*
    委托模式
        通过分配或委托其他对象，委托设计模式能够去除核心对象中的判决和复杂的功能性。
    应用场景
        设计了一个cd类，类中有mp3播放模式，和mp4播放模式
        改进前，使用cd类的播放模式，需要在实例化的类中去判断选择什么方式的播放模式
        改进后，播放模式当做一个参数传入playList函数中，就自动能找到对应需要播放的方法。
*/
//代码：cd类，未改进之前，选择播放模式是一种痛苦的事情
//委托模式-去除核心对象中的判决和复杂的功能性  
//使用委托模式之前，调用cd类，选择cd播放模式是复杂的选择过程  
class cd {  
    protected $cdInfo = array();   
      
    public function addSong($song) {  
        $this->cdInfo[$song] = $song;  
    }  
      
    public function playMp3($song) {  
        return $this->cdInfo[$song] . '.mp3';  
    }  
      
    public function playMp4($song) {  
        return $this->cdInfo[$song] . '.mp4';  
    }  
}  
$oldCd = new cd;  
$oldCd->addSong("1");  
$oldCd->addSong("2");  
$oldCd->addSong("3");  
$type = 'mp3';  
if ($type == 'mp3') {  
    $oldCd->playMp3();  
} else {  
    $oldCd->playMp4();  
}
/*************************************我是分割线****************************************/
//委托模式-去除核心对象中的判决和复杂的功能性  
//改进cd类  
class cdDelegate {  
    protected $cdInfo = array();   
      
    public function addSong($song) {  
        $this->cdInfo[$song] = $song;  
    }  
      
    public function play($type, $song) {  
        $obj = new $type;  
        return $obj->playList($this->cdInfo, $song);  
    }  
}  
  
class mp3 {  
    public function playList($list) {  
        return $list[$song];  
    }  
}  
  
class mp4 {  
    public function playList($list) {  
        return $list[$song];  
    }  
}  
  
$newCd = new cd;  
$newCd->addSong("1");  
$newCd->addSong("2");  
$newCd->addSong("3");  
$type = 'mp3';  
$newCd->play('mp3', '1'); //只要传递参数就能知道需要选择何种播放模式  