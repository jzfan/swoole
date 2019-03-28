<?php

$serverOne = new swoole_http_server('0.0.0.0', 8811);
$serverOne->set([
	'enable_static_handler' => true,
	'document_root' => '/home/fan/www/lara/public' 
]);

$serverOne->on('request', function ($request, $response) {
	$response->end(111111);

});

$serverOne->start();

// $serverTwo = new swoole_http_server('0.0.0.0', 8822);

// $serverTwo->on('request', function ($request, $response) {
// 	$response->end(222222);

// });

// $serverTwo->start();