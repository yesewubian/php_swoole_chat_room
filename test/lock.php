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

    //阻塞
//    echo "[child] wait lock\n";
//    $lock->lock();
//    echo "[child] get lock\n";
//    $lock->unlock();
//    exit("[child] exit\n");

    //非阻塞
    if($lock->trylock()){
        echo "[child] get lock successful\n";
        $lock->unlock();
    }else{
        echo "[child] get lock fail\n";
    }
    exit("[child] exit\n");
}
echo "[master] release lock\n";
unset($lock);
sleep(3);
exit("[master] exit\n");