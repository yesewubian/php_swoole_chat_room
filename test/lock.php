<?php
/**
 *
 */
$lock = new \Swoole\Lock(SWOOLE_MUTEX);
echo "[master]create lock\n";
$lock->lock();
if(pcntl_fork()>0){
    sleep(3);
    $lock->unlock();
}else{
    echo "[child] wait lock\n";
    $lock->lock();
    echo "[child] get lock";
    $lock->unlock();
    exit("[child] exit\n");
}
echo "[master] release lock\n";
unset($lock);
sleep(3);
exit("[master] exit\n");