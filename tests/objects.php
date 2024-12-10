<?php

class Demo
{
    /**
     * @param $a
     * @param $b
     * @return mixed
     * @uses $client->Demoadd(1,2)
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}

class Demo2 implements \Pkg6\EasyRPC\Contracts\Objects
{
    public function register(\Pkg6\EasyRPC\Contracts\Server &$server)
    {
        $server->addCallback('subtract', function ($a, $b) {
            return $a - $b;
        });
    }
}

class LogClientHandle implements \Pkg6\EasyRPC\Contracts\CHandle
{

    public function handle(\Pkg6\EasyRPC\Contracts\Client $client, $method, array $params, $result)
    {
        file_put_contents('c.log', json_encode(compact('method', 'params', 'result')) . PHP_EOL, FILE_APPEND);
    }
}

class LogServerHandle implements \Pkg6\EasyRPC\Contracts\SHandle
{
    public function handle(\Pkg6\EasyRPC\Contracts\Server $server, $method, array $params, $result)
    {
        file_put_contents('s.log', json_encode(compact('method', 'params', 'result')) . PHP_EOL, FILE_APPEND);
    }
}