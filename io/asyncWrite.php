<?php
$mysql = new Swoole\Coroutine\MySQL;
$db = new swoole_mysql;
$data = date('Y-m-d H:i:s') . PHP_EOL;

swoole_async_writefile(__DIR__ . 'test.txt', $data, function ($filename) {
	echo "{$filename} write success";
}, FILE_APPEND);

echo "start first\n";
