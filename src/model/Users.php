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

class Users
{
    public const USERS_API = "https://jsonplaceholder.typicode.com/users";

    protected $client;

    public function __construct(Client $client, string $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    public function data(): array
    {
        return $this->get($this->url);
    }

    private function get(string $url, array $params = []): array
    {
        try {
            $res = $this->client->request('GET', $url);
            return [
                "statusCode" => $res->getStatusCode(),
                "users" => json_decode($res->getBody()->getContents(), true),
            ];
        } catch (RequestException  $exception) {
            return [
                "statusCode" => $exception->getResponse()->getStatusCode(),
                "message" => $exception->getMessage(),
            ];
        } catch (Exception $exception) {
            return [
                "statusCode" => "404",
                "message" => $exception->getMessage(),
            ];
        }
    }

    public static function newInstance(string $url = Users::USERS_API): Users
    {
        require INPSYDE_PATH . "/vendor/autoload.php";
        $stack = HandlerStack::create();
        $stack->push(
            new CacheMiddleware(
                new PrivateCacheStrategy(
                    new FlysystemStorage(
                        new Local(INPSYDE_PATH . 'tmp/cache/guzzle/')
                    )
                ),
                60
            )
        );
        $client = new Client(['handler' => $stack]);
        return new Users($client, $url);
    }
}
