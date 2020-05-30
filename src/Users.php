<?php

require INPSYDE_PATH . "/vendor/autoload.php";

use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\KeyValueHttpHeader;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Doctrine\Common\Cache\FilesystemCache;
use League\Flysystem\Adapter\Local;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use GuzzleHttp\HandlerStack;

class Users 
{
    public const USERS_API = "https://jsonplaceholder.typicode.com/users";

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
        // TODO: Handle error not getting
        // - Long loading time
        // - Cache result

        return $this->get(Users::USERS_API);
    }

    private function get($url, $params = array()) 
    {
        // $header = array(
        //     "Cache-Control: max-age=60"
        // ); 
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url.http_build_query($params));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);

        // // $h = get_header($url, 1);

        // // error_log(print_r($h, true));
        // error_log(print_r(get_headers($url, 1), true));
        // return json_decode($response);


        // error_log(print_r($this->stack, true));
        $res = $this->client->request('GET', $url);
        return json_decode($res->getBody());
        
    }
}
?>