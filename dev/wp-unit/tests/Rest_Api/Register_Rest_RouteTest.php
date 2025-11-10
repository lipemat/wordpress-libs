<?php
declare( strict_types=1 );

namespace Lipe\Lib\Rest_Api;

/**
 * @author Mat Lipe
 * @since  January 2025
 *
 */
class Register_Rest_RouteTest extends \WP_UnitTestCase {

	public function test_single_method(): void {
		$route = new Register_Rest_Route( [] );
		$method = $route->method( \WP_REST_Server::READABLE );
		$method->callback( fn( $request ) => new \WP_REST_Response( [ 'success' => true ] ) )
		       ->permission_callback( fn( $request ) => true );

		$args = $route->get_args();

		$this->assertCount( 1, $args );
		$this->assertIsArray( $args[0] );
		$this->assertSame( \WP_REST_Server::READABLE, $args[0]['methods'] );
		$this->assertInstanceOf( \Closure::class, $args[0]['callback'] );
		$this->assertInstanceOf( \Closure::class, $args[0]['permission_callback'] );
	}


	public function test_multiple_methods(): void {
		$route = new Register_Rest_Route( [] );
		$get = $route->method( \WP_REST_Server::READABLE );
		$get->callback( fn( $request ) => new \WP_REST_Response( [ 'success' => true ] ) )
		    ->permission_callback( fn( $request ) => true );

		$post = $route->method( \WP_REST_Server::CREATABLE );
		$post->callback( fn( $request ) => new \WP_REST_Response( [ 'created' => true ] ) )
		     ->permission_callback( fn( $request ) => false );

		$args = $route->get_args();

		$this->assertCount( 2, $args );
		$this->assertSame( \WP_REST_Server::READABLE, $args[0]['methods'] );
		$this->assertSame( \WP_REST_Server::CREATABLE, $args[1]['methods'] );
	}


	public function test_schema_only(): void {
		$route = new Register_Rest_Route( [] );
		$schema = new Resource_Schema( [] );
		$schema->title( 'Test Schema' )
		       ->type()->string();

		$route->schema( $schema );

		$args = $route->get_args();

		$this->assertArrayHasKey( 'schema', $args );
		$this->assertInstanceOf( \Closure::class, $args['schema'] );
		$callback = $args['schema'];
		$schema_args = $callback();
		$this->assertSame( [
			'title'   => 'Test Schema',
			'$schema' => 'http://json-schema.org/draft-04/schema#',
			'type'    => 'string',
		], $schema_args );
	}


	public function test_method_with_schema(): void {
		$route = new Register_Rest_Route( [] );
		$method = $route->method( \WP_REST_Server::READABLE );
		$method->callback( fn( $request ) => new \WP_REST_Response( [ 'success' => true ] ) )
		       ->permission_callback( fn( $request ) => true );

		$schema = new Resource_Schema( [] );
		$schema->title( 'Combined Schema' )
		       ->type()->object();

		$route->schema( $schema );

		$args = $route->get_args();

		$this->assertArrayHasKey( 'schema', $args );
		$this->assertCount( 2, $args );
		$this->assertInstanceOf( \Closure::class, $args['schema'] );
		$this->assertSame( \WP_REST_Server::READABLE, $args[0]['methods'] );
	}


	public function test_method_with_arguments_schema(): void {
		$route = new Register_Rest_Route( [] );
		$method = $route->method( \WP_REST_Server::CREATABLE );

		$args_schema = new Arguments_Schema( [] );
		$args_schema->prop( 'title' )
		            ->description( 'Post title' )
		            ->type()->string();
		$args_schema->prop( 'content' )
		            ->description( 'Post content' )
		            ->type()->string();

		$method->args( $args_schema )
		       ->callback( fn( $request ) => new \WP_REST_Response( [ 'created' => true ] ) )
		       ->permission_callback( fn( $request ) => true );

		$args = $route->get_args();

		$this->assertCount( 1, $args );
		$this->assertArrayHasKey( 'args', $args[0] );
		$this->assertSame( [
			'title'   => [
				'description' => 'Post title',
				'type'        => 'string',
			],
			'content' => [
				'description' => 'Post content',
				'type'        => 'string',
			],
		], $args[0]['args'] );
	}


	public function test_methods_property_excluded_from_args(): void {
		$route = new Register_Rest_Route( [] );
		$method = $route->method( \WP_REST_Server::READABLE );
		$method->callback( fn( $request ) => new \WP_REST_Response( [] ) )
		       ->permission_callback( fn( $request ) => true );

		$args = $route->get_args();

		$this->assertArrayNotHasKey( 'methods', $args );
		$this->assertArrayHasKey( 'methods', $args[0] );
	}


	public function test_multiple_methods_with_different_args(): void {
		$route = new Register_Rest_Route( [] );

		$get = $route->method( \WP_REST_Server::READABLE );
		$get_args = new Arguments_Schema( [] );
		$get_args->prop( 'id' )
		         ->description( 'Resource ID' )
		         ->type()->integer();
		$get->args( $get_args )
		    ->callback( fn( $request ) => new \WP_REST_Response( [ 'id' => $request['id'] ] ) )
		    ->permission_callback( fn( $request ) => true );

		$post = $route->method( \WP_REST_Server::CREATABLE );
		$post_args = new Arguments_Schema( [] );
		$post_args->prop( 'title' )
		          ->description( 'Resource title' )
		          ->type()->string();
		$post->args( $post_args )
		     ->callback( fn( $request ) => new \WP_REST_Response( [ 'title' => $request['title'] ] ) )
		     ->permission_callback( fn( $request ) => false );

		$args = $route->get_args();

		$this->assertCount( 2, $args );
		$this->assertArrayHasKey( 'id', $args[0]['args'] );
		$this->assertArrayHasKey( 'title', $args[1]['args'] );
		$this->assertArrayNotHasKey( 'title', $args[0]['args'] );
		$this->assertArrayNotHasKey( 'id', $args[1]['args'] );
	}


	public function test_complex_schema_with_multiple_methods(): void {
		$route = new Register_Rest_Route( [] );

		$schema = new Resource_Schema( [] );
		$props = $schema->title( 'User Resource' )
		                ->type()->object();
		$props->prop( 'id' )
		      ->description( 'User ID' )
		      ->type()->integer();
		$props->prop( 'name' )
		      ->description( 'User name' )
		      ->type()->string();

		$route->schema( $schema );

		$get = $route->method( \WP_REST_Server::READABLE );
		$get->callback( fn( $request ) => new \WP_REST_Response( [] ) )
		    ->permission_callback( fn( $request ) => true );

		$post = $route->method( \WP_REST_Server::CREATABLE );
		$post->callback( fn( $request ) => new \WP_REST_Response( [] ) )
		     ->permission_callback( fn( $request ) => true );

		$args = $route->get_args();

		$this->assertArrayHasKey( 'schema', $args );
		$this->assertCount( 3, $args );

		$callback = $args['schema'];
		$schema_args = $callback();
		$this->assertSame( 'User Resource', $schema_args['title'] );
		$this->assertArrayHasKey( 'id', $schema_args['properties'] );
		$this->assertArrayHasKey( 'name', $schema_args['properties'] );
	}
}
