<?php
//PHP多线程实例
class my_thread extends Thread
{
	//实例父类的方法
	function run(){
		for($i = 1; $i < 10; $i++){
			echo "此线程的ID是" . Thread::getCurrentThreadId() . "\n";
			sleep(2);
		}
	}
}

//创建两个线程	
for($i =0 ; $i < 2; $i++){
	$pool[] = new my_thread();
}

//运行线程
foreach ($pool as $worker) {
	$worker->start();
}

foreach ($pool as $worker) {
	$worker->join();
}
