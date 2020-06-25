<?php

require dirname(__FILE__, 2) . "/vendor/autoload.php";

use Brain\Monkey;
use Brain\Monkey\Functions;

use Inpsyde\Model\Users;

class MyTestCase extends PHPUnit_Framework_TestCase
{
    protected function setUp() {
        parent::setUp();
        Monkey\setUp();
    }

    public function testUsersData() {
        $object = \Mockery::mock('WP_Http');
        Functions\when('wp_remote_get')->justReturn($object);
        Functions\when('wp_remote_retrieve_body')->justReturn(
            json_encode(
                array(
                    array("id" => 1, "name" => "Nico", "username" => "UserNico")
                )
            )
        );

        $users = new Users();
        $data = $users->data();
        $this->assertEquals($data['statusCode'], 200);
        $usersData = $data["users"];
        $user = $usersData[0];
        $this->assertEquals(is_array($usersData), true);
        $this->assertEquals(count($usersData) > 0, true);
        $this->assertEquals(isset($user['id']), true);
        $this->assertEquals(isset($user['name']), true);
        $this->assertEquals(isset($user['username']), true);
    }

    public function testFailedGettingUsersDataInvalidUrl() {
        $object = \Mockery::mock('WP_Error');
        $object
            ->shouldReceive('get_error_message')
            ->once()
            ->withNoArgs()
            ->andReturn("A valid URL was not provided.");
        Functions\when('wp_remote_get')->justReturn($object);

        $users = new Users();
        $data = $users->data();
        $this->assertEquals($data['statusCode'], 404);
        $this->assertEquals($data['message'], "A valid URL was not provided.");
    }

    protected function tearDown()
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    // public function testError500() {
    //     $mock = new MockHandler([
    //         new RequestException('Error Communicating with Server', 
    //             new Request('GET', 'test'),
    //             new Response(500)
    //         )]
    //     );

    //     $stack = HandlerStack::create($mock);
    //     $client = new Client(['handler' => $stack]);
    //     $users = new Users($client, Users::USERS_API);
    //     $data = $users->data();

    //     $this->assertEquals($data['statusCode'], 500);
    // }

    // public function testError503() {
    //     // Actual Exception message is longer
    //     $mock = new MockHandler([
    //         new RequestException('503 Service Unavailable', 
    //             new Request('GET', 'test'),
    //             new Response(503)
    //         )]
    //     );

    //     $stack = HandlerStack::create($mock);
    //     $client = new Client(['handler' => $stack]);
    //     $users = new Users($client, Users::USERS_API);
    //     $data = $users->data();
    //     $this->assertEquals($data['statusCode'], 503);
    // }


    // // Integration tests
    // public function testUsersDataWithAPICall() {
    //     $users = Users::newInstance();
    //     $data = $users->data();

    //     $this->assertEquals($data['statusCode'], 200);

    //     $users = $data["users"];
    //     $this->assertEquals(is_array($users), true);
    //     $this->assertEquals(count($users) > 0, true);
    //     $this->assertEquals(isset($users[0]['id']), true);
    //     $this->assertEquals(isset($users[0]['name']), true);
    //     $this->assertEquals(isset($users[0]['username']), true);
    // }
}

?>