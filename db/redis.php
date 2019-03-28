<?php

class RedisPool
{
    /**@var \Swoole\Coroutine\Channel */
    protected $pool;

    /**
     * RedisPool constructor.
     * @param int $size max connections
     */
    public function __construct(int $size = 100)
    {
        $this->pool = new \Swoole\Coroutine\Channel($size);
        for ($size; $size--;) {
            $redis = new Swoole\Coroutine\Redis();
            $res = $redis->connect('127.0.0.1', 6379);
            if ($res == false) {
                throw new \RuntimeException("failed to connect redis server.");
            } else {
                $this->put($redis);
            }
        }
    }

    public function get(): \Swoole\Coroutine\Redis
    {
        return $this->pool->pop();
    }

    public function put(\Swoole\Coroutine\Redis $redis)
    {
        $this->pool->push($redis);
    }

    public function close(): void
    {
        $this->pool->close();
        $this->pool = null;
    }
}

$s = microtime(true);
go(function () {
    $pool = new RedisPool();
    // max concurrency num is more than max connections
    // but it's no problem, channel will help you with scheduling
    for ($c=100; $c--;) {
        go(function () use ($pool, $c) {
            for ($n=100; $n--;) {
                $redis = $pool->get();
                // assert($redis->set("awesome-{$c}-{$n}", time()));
                $redis->set("awesome-{$c}-{$n}", time());
                $str = $redis->get("awesome-{$c}-{$n}");
                // var_dump($str);
                $redis->delete("awesome-{$c}-{$n}");
                // assert($redis->delete("awesome-{$c}-{$n}"));
                $pool->put($redis);
            }
        });
    }
});
Swoole\Event::wait();
echo 'use ' . (microtime(true) - $s) . ' s' . PHP_EOL;