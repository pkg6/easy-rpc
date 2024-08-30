<?php
class Demo
{
    public function add($a,$b)
    {
        return $a + $b;
    }
}

class Demo2 implements \Pkg6\EasyRPC\Contracts\Objects
{
    public function register(\Pkg6\EasyRPC\Contracts\Server &$server)
    {
        $server->addCallback('subtract',function ($a,$b){
            return $a - $b;
        });
    }
}