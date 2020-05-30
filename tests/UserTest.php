<?php
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

require dirname(__FILE__, 2) . '/src/Users.php';

class UserTest extends \PHPUnit\Framework\TestCase
{

    public function testTesting() {
        $users = new Users();

        // TODO 
        // - Test the getData()
        // - Break it down to make it testable
        $this->assertEquals("1", "1");

    }
}

?>