<?php
include_once 'vendor/autoload.php';
try {
    $server = new \lib\swoole\WebSocketServer('0.0.0.0', 9501);
    $server->run();
}catch (Exception $e){
    echo $e->getMessage();
}
