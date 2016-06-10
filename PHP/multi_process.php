<?php
//PHP的多进程
class StatInfo{
    public static $procContain = 20000;
    public static $maxProc = 10;
    public static $isChild = null;
    protected static $run = true;
    protected static $subProcessed = array();

    public function run(){
        $begin_process = 0;//进程开始个数
        self::$subProcessed = array();
        $procCount = 0;
        while ($procCount < self::$maxProc) {
            $pid = pcntl_fork();
            $begin_process++;
            ++$procCount;
            if(0 == $pid){//child
                //这里是子进程执行的逻辑
                self::$isChild = true;
                $this->forkRun(self::$procContain*($procCount-1));
            }else if(0 < $pid){//parent
                //这里是父进程执行的逻辑
                self::$isChild = false;
                self::$subProcessed[] = $pid;
                continue;
            }else{
                break;
            }
        }
		
        //管理子进程状态,$begin_process记录了启动了几个子进程
        //当返回一个 $begin_process--,当$begin_process=0时子进程全部结束了。
        while (self::$run) {
            $status = 0;
            $pid = pcntl_waitpid(-1, $status, WUNTRACED);
            if (0 <= $pid) {
                $begin_process--;
            }
            if ($begin_process == 0){
                self::$run = false;
                break;
            }
        }
    }

	 public function forkRun($start) {
        $offset = 1;
        $count = 200;

        while ($offset < 5) {
            $begin = $start+$offset;
            $end = $begin+self::$procContain;
            echo $end . "\n";
			++$offset;
			sleep(rand(1,5));
		}
		exit;
	}
}
$obj = new StatInfo;
$obj->run();
