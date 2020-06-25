<?php declare(strict_types=1);

namespace Inpsyde\Model;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use League\Flysystem\Adapter\Local;
use GuzzleHttp\Exception\RequestException;

use Exception;

/**
 * Model for the users data
 * 
 * @package  Inpsyde\Model
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 */
class Users
{
    public const USERS_API = "https://jsonplaceholder.typicode.com/users";
    
    /**
     * __construct
     * 
     * @param  mixed $url
     * @return void
     */
    public function __construct(string $url = Users::USERS_API)
    {
        $this->url = $url;
    }
    
    /**
     * data
     *
     * @return array
     */
    public function data(): array
    {
        return $this->get($this->url);
    }
    
    /**
     * get
     *
     * @param  mixed $url The endpoint to fetch data
     * @return array
     */
    private function get(string $url): array
    {
        /** TODO, add more robust error checking */
        $request = \wp_remote_get($url);
        if( is_wp_error($request)) {
            return [
              "statusCode" => 404,
              "message" => $request->errors['http_request_failed'][0]
            ];
        }
        
        $body = wp_remote_retrieve_body($request);
        return [
          "statusCode" => 200,  // Refactor, get the statusCode if possible
          "users" => json_decode($body, true)
        ];
    }
}
