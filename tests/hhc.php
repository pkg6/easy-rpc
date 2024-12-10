<?php

require 'vendor/autoload.php';

use Pkg6\EasyRPC\HproseHttp\Client;

$client = new Client();
require 'objects.php';
$client->withURL("http://127.0.0.1:8000");
$client->withAuthentication('user1','password1');
$client->withHandle(new LogClientHandle());
$add = $client->add(1,2);
$demoAdd = $client->Demoadd(1,4);
$subtract = $client->subtract(4,2);

var_dump($add);
var_dump($demoAdd);
var_dump($subtract);