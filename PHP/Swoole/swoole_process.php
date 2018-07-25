<?php
function doProcess(swoole_process $worker)
{
    echo 'PID', $worker->pid,PHP_EOL;
    sleep(rand(1,20));
}

for($i=0; $i < 10; $i++){
    $process = new swoole_process('doProcess');//创建进程
    $pid = $process->start();//开启进程 并返回进程id
}

while($res = swoole_process::wait()){
    $pid = $res['pid'];
    echo 'Worker Exit, PID=' . $pid . PHP_EOL;
}
