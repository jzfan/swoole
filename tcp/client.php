<?php

$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect('127.0.0.01', 9501)) {
	echo 'connect failed';
	exit;
}

fwrite(STDOUT, 'please input:');
$message = trim(fgets(STDIN));

$client->send($message);

$response = $client->recv();
echo $response . PHP_EOL;

