<?php

$config = require_once('../config.php');

$s = microtime(true);
for ($c = 100; $c--;) {
    go(function () use ($config){
        $mysql = new Swoole\Coroutine\MySQL;
        $mysql->connect($config['mysql']);
        $statement = $mysql->prepare('SELECT * FROM `user`');
        for ($n = 100; $n--;) {
            $result = $statement->execute();
            assert(count($result) > 0);
        }
    });
}
echo 'use ' . (microtime(true) - $s) . ' s before wait' . PHP_EOL;
Swoole\Event::wait();
echo 'use ' . (microtime(true) - $s) . ' s' . PHP_EOL;