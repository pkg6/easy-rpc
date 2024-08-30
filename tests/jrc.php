<?php

require 'vendor/autoload.php';
use Pkg6\EasyRPC\JsonRPCHttp\Client;
$client = new Client();
$client->withURL("http://127.0.0.1:8000");
$add = $client->add(1,2);
$demoAdd = $client->Demoadd(1,4);
$subtract = $client->subtract(4,2);

var_dump($add);
var_dump($demoAdd);
var_dump($subtract);