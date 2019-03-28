<?php

/**
 * websocket class
 */
class Ws
{
	const HOST = '0.0.0.0';
	const PORT = 8899;
	
	public function __construct()
	{
		$server = new swoole_websocket_server(self::HOST, self::PORT);
		$server->set([
			'worker_num' => 2,
			'task_worker_num' => 2
		]);
		$server->on('open', [$this, 'onOpen']);
		$server->on('message', [$this, 'onMessage']);
		$server->on('close', [$this, 'onClose']);
		$server->on('task', [$this, 'onTask']);
		$server->on('finish', [$this, 'onFinish']);
		$server->start();
	}

	public function onOpen($server, $request)
	{
		echo "Client {$request->fd} connected\n";
		$server->push($request->fd, 'greeting from server');
	}

	public function onMessage($server, $frame)
	{
		echo "receive from client {$frame->fd} : {$frame->data}\n";
		$server->push($frame->fd, 'server push sucsess');
		//let's create a task
		$server->task(['at' => 1, 'do' => 'coding']);
		$server->push($frame->fd, 'server start a task');
	}

	public function onTask($server, $taskId, $workerId, $data)
	{
		echo "task begging!!!\n";
		echo "taskId : {$taskId}\n";
		echo "taskData : \n";
		print_r($data);
		echo "workerId : {$workerId}\n";
		// do some task use $data
		sleep(5);
		return "some task result\n";
	}

	public function onFinish($server, $taskId, $data)
	{
		echo "task finished\n";
		echo "taskId : {$taskId}\n";
		echo "task return : {$data}";
	}

	public function onClose($server, $fd)
	{
		echo "client {$fd} closed\n";
	}

}

$ws = new Ws;