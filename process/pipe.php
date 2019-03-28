<?php

$process = new Swoole\process(function ($process) {
	// echo "message 1 from prosessing\n";
	sleep(2);
	echo "message 2 from prosessing\n";
	// var_dump($process);
}, true);

$pid = $process->start();
echo "start process {$pid}\n";
echo $process->read();
