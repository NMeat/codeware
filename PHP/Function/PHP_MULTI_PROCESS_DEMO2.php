<?php
//PHP的多进程
class StatInfo
{
    public static $procContain = 20000;
    public static $maxProc = 5;
    protected static $subProcessed = array();

    public function run()
    {
        $begin_process = $procCount = 1;
        //创建5个进程
        while ($procCount <= self::$maxProc) {
            $pid = pcntl_fork();   //创建进程
            ++$begin_process;
            ++$procCount;

            if(0 == $pid){  //子进程会返回0
                //这里是子进程执行的逻辑
                $this->forkRun(self::$procContain * ($procCount - 1));
                exit(0);    //子进程退出
            }else if(0 < $pid){     //父进程会得到大于0的子进程id号
                //这里是父进程执行的逻辑
                self::$subProcessed[] = $pid;
            }else{  //创建子进程失败会返回-1
                echo '创建子进程失败' . "\n";
            }
        }
		
        while (true) {
            $res = pcntl_waitpid(-1, $status, WUNTRACED);
            if($res == 0 || $res == -1){
                break;
            }
        }
    }
  	
	public function forkRun($start)
	{
		$start_set = 1;
		while($start_set <= 5){
			echo $start . "\n";
			sleep(rand(1,5));
			++$start_set;
		}
	}
}
$obj = new StatInfo();
$obj->run();