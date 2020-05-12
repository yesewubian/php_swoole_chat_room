<?php
/**
 * Created by PhpStorm.
 * Date: 2020/5/12
 * Time: 16:54
 */

use Swoole\Process;

for ($n = 1; $n <= 3; $n++) {
    sleep(2);
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