<?php

$server = new \lib\swoole\WebSocketServer('101.37.145.203',9501);
$server->run();