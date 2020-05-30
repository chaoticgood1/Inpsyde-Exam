<?php

require INPSYDE_PATH . "/vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use League\Flysystem\Adapter\Local;
use GuzzleHttp\Exception\ClientException;


class Users 
{
    public const USERS_API = "https://jsonplaceholder.typicode.com/users";

    protected $client;

    function __construct($client, $url) {
        $this->client = $client;
        $this->url = $url;
    }

    public function getData()
    {
        $data = $this->get($this->url);
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

    public static function newInstance($url = Users::USERS_API) {
        $stack = HandlerStack::create();
        $stack->push(
        new CacheMiddleware(
            new PrivateCacheStrategy(
                new FlysystemStorage(
                    new Local(INPSYDE_PATH . './tmp/cache/guzzle/')
                )
            ), 60
        ));
        $client = new Client(['handler' => $stack]);
        return new Users($client, $url);
    }
}
?>