<?php

namespace PluginTest\Stuff;
use \Plugin\Stuff\SomeClass;
use \Brain\Monkey\Functions;

class SomeClassTest extends \PluginTestCase {
	public function test_construct() {
		// arrange
		$_SERVER['REQUEST_METHOD'] = 'POST';
		$_POST = [ 'foo' => '\\\'asas' ];
		// We expect wp_unslash to be called during bootstrap
		Functions\expect( 'wp_unslash' )
			->once()
			->with( $_POST )
			->andReturnFirstArg();
		// We expect plugins_url to be called
		Functions\expect( 'plugins_url' )
			->once()
			->with( '/dist/', PLUGIN_ABSPATH )
			->andReturn( 'https://eform.test/foo/dist/' );
		// Fire
		$stub = $this->getMockForAbstractClass( SomeClass::class );
		$stub_class = get_class( $stub );
		// $base = new \EFormStub\StubAdminBase();
		// We expect admin_menu action to have been added when calling register
		$this->assertTrue( has_action( 'admin_menu', "{$stub_class}->admin_menu()" ) );
		// Assert
		$this->assertEquals( $_POST, $stub->get_post() );
	}
}

