<?php

use PHPUnit_Framework_TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;

class MyTestCase extends PHPUnit_Framework_TestCase
{
    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    protected function tearDown()
    {
        Monkey\tearDown();
        parent::tearDown();
    }
}

?>