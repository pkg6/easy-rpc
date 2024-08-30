<?php

use Pkg6\EasyRPC\HproseHttp\Server;

require 'vendor/autoload.php';
require 'objects.php';
$s = new Server();
$s->addCallback('add',function ($a,$b){
    return $a + $b;
});
$s->addObjectClass(Demo::class);
$s->addObjectClass(Demo2::class);
$s->start();
