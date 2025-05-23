<?php declare(strict_types=1);

namespace Inpsyde\Model;

use Exception;

/**
 * Model for the users data, to be instantiated in the UserPage.php
 *
 * @package  Inpsyde\Model
 * @author   Monico Colete <colete_nico@yahoo.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 */
class Users
{
    public const API = "https://jsonplaceholder.typicode.com/users";
    
    /**
     *
     * @param  mixed $url The endpoint to fetch data
     * @return void
     */
    public function __construct(string $url = Users::API)
    {
        $this->url = $url;
    }
    
    /**
     * Data of all the users
     *
     * @return array Result of getting the data of users
     */
    public function data(): array
    {
        return $this->get($this->url);
    }
    
    /**
     * Get implementation to fetch users data
     *
     * @param  mixed $url The endpoint to fetch data
     * @return array Result of fetching the url users data
     */
    private function get(string $url): array
    {
        $args = ["headers" => ["Cache-Control" => "max-age=60"]];
        $request = wp_safe_remote_get($url, $args);
        if (is_wp_error($request)) {
            return [
              "statusCode" => 404,
              "message" => $request->get_error_message(),
            ];
        }
        $body = wp_remote_retrieve_body($request);
        return [
          "statusCode" => 200,  // Refactor, get the statusCode if possible
          "users" => json_decode($body, true),
        ];
    }
}
