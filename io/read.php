<?php

go(function () {
	$file = fopen(__DIR__ . 'test.txt', 'rb');
});
swoole_async_readfile(__DIR__ . 'test.txt', function ($filename, $filecontent) {
	echo "filename: {$filename}\n";
	echo "content: {$filecontent}\n";
});

echo "start first\n";
