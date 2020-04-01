<?php
include_once 'vendor/autoload.php';
$server = new \lib\swoole\WebSocketServer('0.0.0.0',9501);
$server->run();
