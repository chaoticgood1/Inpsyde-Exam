<?php

require INPSYDE_PATH . "/vendor/autoload.php";

use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

use League\Flysystem\Adapter\Local;

use GuzzleHttp\HandlerStack;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class Users 
{
    public static $USERS_API = "https://jsonplaceholder.typicode.com/users";

    private $stack;
    private $client;

    function __construct() {
        $this->initClientWithCaching();
    }

    private function initClientWithCaching() {
        $stack = HandlerStack::create();
        $stack->push(
        new CacheMiddleware(
            new PrivateCacheStrategy(
                new FlysystemStorage(
                    new Local(INPSYDE_PATH . './tmp/cache/guzzle/')
                )
            ), 60
        ));

        $this->stack = $stack;
        $this->client = new GuzzleHttp\Client(['handler' => $stack]);
    }

    public function getData() // Rename? Later
    {
        $data = $this->get(Users::$USERS_API);
        if ($data["statusCode"] == "200") {
            return $data["users"];
        }
        return [];
    }

    private function get($url, $params = array()) 
    {   
        try {
            $res = $this->client->request('GET', $url);
            return [
                "statusCode" => $res->getStatusCode(),
                "users" => json_decode($res->getBody())
            ];
        } catch (ClientException $e) {
            return [
                "statusCode" => $e->getResponse()->getStatusCode(),
                "message" => $e->getMessage()   
            ];
        }
    }
}
?>