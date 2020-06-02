<?php
/**
 * Created by PhpStorm.
 * Date: 2020/5/12
 * Time: 16:54
 */

use Swoole\Process;

/*
for ($n = 1; $n <= 3; $n++) {
    echo 'sleep 10s'.PHP_EOL;
    sleep(10);
    $process = new Process(function () use ($n) {
        echo 'child #' . getmypid() . " start and sleep ($n)s" . PHP_EOL;
        sleep($n);
        echo 'child #' . getmypid() . 'exit' . PHP_EOL;
    });
    $process->start();
}
for ($n = 3; $n > 0; $n--) {
    $status = Process::wait();
    echo "Recycled #{$status['pid']}, code={$status['code']}, signal={$status['signal']}" . PHP_EOL;
}
echo 'Parent #' . getmypid() . ' exit' . PHP_EOL;
*/

function callback_function(){
    swoole_timer_after(1000,function (){
       echo 'hello world'.PHP_EOL;
    });
}

swoole_timer_tick(1000,function (){
   echo 'parent timer'.PHP_EOL;
   foreach (\Swoole\Timer::list() as $timer_id){
       \Swoole\Timer::clear($timer_id);
   }
});

Process::signal(SIGCHLD,function ($sig){
    while ($ret = Process::wait(false)){
        $p = new Process('callback_function');
        $p->start();
    }
});

$p = new Process('callback_function');
$p->start();