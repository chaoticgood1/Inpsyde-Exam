<?php
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

require dirname(__FILE__, 2) . '/src/Users.php';

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
        $data = $users->getData();

        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) > 0, true);
        $this->assertEquals(isset($data[0]->id), true);
        $this->assertEquals(isset($data[0]->name), true);
        $this->assertEquals(isset($data[0]->username), true);
    }

    public function testErrorEmptyData() {
        $body = json_encode(array(
            array("id" => 1, "name" => "Nico", "username" => "UserNico")
            )
        );
        $mock = new MockHandler([
            new ClientException('Error Communicating with Server', 
                new Request('GET', 'test'),
                new Response(500)
            )]
        );

        $stack = HandlerStack::create($mock);
        $client = new Client(['handler' => $stack]);

        $users = new Users($client, Users::USERS_API);
        
        $data = $users->getData();
        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) == 0, true);
    }

    // Integration tests
    public function testUsersDataWithAPICall() {
        $users = Users::newInstance();
        $data = $users->getData();

        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) > 0, true);
        $this->assertEquals(isset($data[0]->id), true);
        $this->assertEquals(isset($data[0]->name), true);
        $this->assertEquals(isset($data[0]->username), true);
    }


    public function testEmptyUsersDataWithWrongAPICall() {
        $wrongAPI = "https://jsonplaceholder.typicode.com/wrong";
        $users = Users::newInstance($wrongAPI);
        $data = $users->getData();
        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) == 0, true);
    }
}

?>