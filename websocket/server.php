<?php

$server = new swoole_websocket_server('0.0.0.0', 8899);

$server->on('open', function ($server, $request) {
	echo "Client {$request->fd} connected\n";
	$server->push($request->fd, 'greeting from server');
});

$server->on('message', function ($server, $frame) {
	echo "receive from client {$frame->fd} : {$frame->data}\n";
	$server->push($frame->fd, 'push sucsess');
});

$server->on('close', function ($server, $fd) {
	echo "client {$fd} closed\n";
});

$server->start();
