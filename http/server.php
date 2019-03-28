<?php

$server = new swoole_http_server('0.0.0.0', 8822);
$server->set(['worker_num' => 4, 'max_request' => 10000 ]);
$server->set([
	'enable_static_handler' => true,
	'document_root' => '/home/fan/www/lara/public' 
]);

$server->on('request', function ($request, $response) {
	$str = json_encode([
		'get' => $request->get,
	]);
	$response->header('Content-Type', 'application/json');	
	$response->cookie('cookieKie', 'cookieValue', time()+1800);
	$response->end($str);

});

$server->start();

//browser http://192.168.137.2:8888/?id=234
//{"get":{"id":"234"}}
