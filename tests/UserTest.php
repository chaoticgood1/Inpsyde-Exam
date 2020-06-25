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
        Functions\when('wp_safe_remote_get')->justReturn($object);
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
        Functions\when('wp_safe_remote_get')->justReturn($object);

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
}

?>