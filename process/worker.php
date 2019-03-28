<?php

$process = new Swoole\process(function ($process) {
	echo "start a http server\n";
	// var_dump($process);
	$process->exec('/usr/bin/php', [__DIR__ . '/../http/server.php']);
}, false);

$pid = $process->start();
echo "start process {$pid}\n";

// Swoole\Event::wait();