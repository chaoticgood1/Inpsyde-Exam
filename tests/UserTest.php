<?php
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

use Inpsyde\Model\Users;

require dirname(__FILE__, 2) . '/src/model/Users.php';

class UserTest extends \PHPUnit\Framework\TestCase
{

    public function testUsersData() {
        $body = json_encode(array(
            array("id" => 1, "name" => "Nico", "username" => "UserNico")
            )
        );
        $mock = new MockHandler([new Response(200, [], $body)]);
        $stack = HandlerStack::create($mock);
        $client = new Client(['handler' => $stack]);
        $users = new Users($client, Users::USERS_API);
        $data = $users->data();

        $this->assertEquals($data['statusCode'], 200);

        $users = $data["users"];
        $this->assertEquals(is_array($users), true);
        $this->assertEquals(count($users) > 0, true);
        $this->assertEquals(isset($users[0]['id']), true);
        $this->assertEquals(isset($users[0]['name']), true);
        $this->assertEquals(isset($users[0]['username']), true);
    }

    public function testError500() {
        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', 
                new Request('GET', 'test'),
                new Response(500)
            )]
        );

        $stack = HandlerStack::create($mock);
        $client = new Client(['handler' => $stack]);
        $users = new Users($client, Users::USERS_API);
        $data = $users->data();

        $this->assertEquals($data['statusCode'], 500);
    }

    public function testError503() {
        // Actual Exception message is longer
        $mock = new MockHandler([
            new RequestException('503 Service Unavailable', 
                new Request('GET', 'test'),
                new Response(503)
            )]
        );

        $stack = HandlerStack::create($mock);
        $client = new Client(['handler' => $stack]);
        $users = new Users($client, Users::USERS_API);
        $data = $users->data();
        $this->assertEquals($data['statusCode'], 503);
    }


    // Integration tests
    public function testUsersDataWithAPICall() {
        $users = Users::newInstance();
        $data = $users->data();

        $this->assertEquals($data['statusCode'], 200);

        $users = $data["users"];
        $this->assertEquals(is_array($users), true);
        $this->assertEquals(count($users) > 0, true);
        $this->assertEquals(isset($users[0]['id']), true);
        $this->assertEquals(isset($users[0]['name']), true);
        $this->assertEquals(isset($users[0]['username']), true);
    }
}

?>