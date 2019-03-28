<?php
$server = new Swoole\Server("127.0.0.1", 9501);
$server->set(['worker_num' => 4, 'max_request' => 10000 ]);
$server->on('connect', function ($server, $fd){
    echo "Client {$fd}:Connect.\n";
});
$server->on('receive', function ($server, $fd, $reactor_id, $data) {
    $server->send($fd, "Serv {$reactor_id} received {$data} from Client {$fd}");
});
$server->on('close', function ($server, $fd) {
    echo "Client {$fd}: Close.\n";
});
$server->start();
