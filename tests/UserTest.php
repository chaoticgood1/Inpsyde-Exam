<?php
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

require dirname(__FILE__, 2) . '/src/Users.php';

class UserTest extends \PHPUnit\Framework\TestCase
{

    private $users;
 
    protected function setUp():void
    {
        $this->users = new Users();
    }

    public function testUsersData() {
        $data = $this->users->getData();

        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) > 0, true);
        $this->assertEquals(isset($data[0]->id), true);
        $this->assertEquals(isset($data[0]->name), true);
        $this->assertEquals(isset($data[0]->username), true);
    }

    public function testEmptyUsersDataWrongAPICall() {
        Users::$USERS_API = "https://jsonplaceholder.typicode.com/wrong";
        $data = $this->users->getData();
        $this->assertEquals(is_array($data), true);
        $this->assertEquals(count($data) == 0, true);
    }
}

?>