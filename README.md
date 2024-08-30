## Installation

~~~
composer require pkg6/easy-rpc
~~~

## initialization

### Server

~~~
$s = new Server();
$s->addCallback('add', function ($a, $b) {
    return $a + $b;
});
$s->start();
~~~

### Client

~~~
$client = new Client();
$client->withURL("http://127.0.0.1:8000");
$add = $client->add(1,2);
~~~

> addObjectClass refer to：https://github.com/pkg6/easy-rpc/blob/main/tests/objects.php

## Interfaces

### Server Interface

~~~
interface Server
{
    /**
     * Callback binding:
     * @param $method
     * @param Closure $callback
     * @return $this
     */
    public function addCallback($method, Closure $callback);

    /**
     * Class/Method binding:
     * @param $objectOrClass
     * @return $this
     */
    public function addObjectClass($objectOrClass);

    /**
     * List of users to allow
     * @param array $authentications
     * @return $this
     */
    public function withAuthentications(array $authentications);

    /**
     * IP client restrictions
     * @param array $hosts
     * @return $this
     */
    public function allowHosts(array $hosts);

    /**
     * @return mixed
     */
    public function start();
}
~~~

### Client Interface

~~~
interface Client
{
    /**
     * @param $url
     * @return $this
     */
    public function withURL($url);

    /**
     * @param $timeout
     * @return $this
     */
    public function withTimeout($timeout);

    /**
     * @return $this
     */
    public function withDebug();

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withAuthentication($username, $password);
}
~~~

