<?php
/**
 * Tests for the Thing schema.
 *
 * @package Schemify
 */

namespace Schemify\Schemas;

use WP_Mock as M;

use Mockery;
use ReflectionMethod;
use ReflectionProperty;
use Schemify;

class ThingTest extends Schemify\TestCase {

	protected $testFiles = array(
		'schemas/Thing.php',
	);

	public function testGetProperties() {
		$data     = array( 'foo' => 'bar' );
		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )
			->shouldAllowMockingProtectedMethods()
			->makePartial();
		$instance->shouldReceive( 'build' )
			->once()
			->andReturn( $data );

		$this->assertEquals( $data, $instance->getProperties() );
	}

	public function testGetPropertiesCachesResults() {
		$data     = array( 'foo' => 'bar' );
		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )
			->shouldAllowMockingProtectedMethods()
			->makePartial();
		$instance->shouldReceive( 'build' )
			->once()
			->andReturn( $data );
		$property = new ReflectionProperty( $instance, 'data' );
		$property->setAccessible( true );

		// Ensure we're starting empty
		$this->assertEmpty( $property->getValue( $instance ) );

		// Execute, verify our $data is now in $this->data.
		$instance->getProperties();

		$this->assertEquals( $data, $property->getValue( $instance ) );
	}

	public function testGetPropertiesCastsOutputAsArray() {
		$data = new \stdClass;
		$data->foo = 'bar';

		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )->makePartial();
		$property = new ReflectionProperty( $instance, 'data' );
		$property->setAccessible( true );
		$property->setValue( $instance, $data );

		$this->assertEquals( array( 'foo' => 'bar' ), $instance->getProperties() );
	}

	public function testGetSchema() {
		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )->makePartial();

		M::wpFunction( __NAMESPACE__ . '\get_class', array(
			'return' => __NAMESPACE__ . '\Thing',
		) );

		$this->assertEquals( 'Thing', $instance->getSchema() );
	}

	public function testGetSchemaCachesResult() {
		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )->makePartial();
		$property = new ReflectionProperty( $instance, 'schema' );
		$property->setAccessible( true );

		M::wpFunction( __NAMESPACE__ . '\get_class', array(
			'return' => __NAMESPACE__ . '\Thing',
		) );

		$instance->getSchema();

		$this->assertEquals( 'Thing', $property->getValue( $instance ) );
	}

	public function testGetSchemaPullsFromCache() {
		$instance = Mockery::mock( __NAMESPACE__ . '\Thing' )->makePartial();
		$random   = uniqid();
		$property = new ReflectionProperty( $instance, 'schema' );
		$property->setAccessible( true );
		$property->setValue( $instance, $random );


		$this->assertEquals( $random, $instance->getSchema() );
	}

	public function testGetPropertyList() {

	}
}