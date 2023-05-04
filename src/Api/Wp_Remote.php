<?php
declare( strict_types=1 );

namespace Lipe\Lib\Api;

use Lipe\Lib\Query\Args_Abstract;

/**
 * A fluent interface for calling the `wp_remote_*` functions.
 *
 * @author Mat Lipe
 * @since  4.1.0
 *
 * @see    wp_safe_remote_post
 * @see    wp_safe_remote_get
 * @see    wp_remote_post
 * @see    wp_remote_get
 * @see    wp_remote_request
 * @see    wp_safe_remote_request
 *
 * @link   https://developer.wordpress.org/reference/functions/wp_remote_post/
 * @link   https://developer.wordpress.org/reference/classes/wp_http/request/
 *
 */
class Wp_Remote extends Args_Abstract {
	public const METHOD_GET     = 'GET';
	public const METHOD_POST    = 'POST';
	public const METHOD_HEAD    = 'HEAD';
	public const METHOD_PUT     = 'PUT';
	public const METHOD_DELETE  = 'DELETE';
	public const METHOD_TRACE   = 'TRACE';
	public const METHOD_OPTIONS = 'OPTIONS';
	public const METHOD_PATCH   = 'PATCH';

	/** @var array<string, string> */
	protected array $map = [
		'user_agent' => 'user-agent',
	];

	/**
	 * Request method.
	 *
	 * Some transports technically allow others, but should not be assumed.
	 *
	 * Default 'GET'.
	 *
	 * @phpstan-var self::METHOD_*
	 *
	 * @var string
	 */
	public string $method;

	/**
	 * How long the connection should stay open in seconds.
	 *
	 * Default 5.
	 *
	 * @var float
	 */
	public float $timeout;

	/**
	 * Number of allowed redirects. Not supported by all transports.
	 *
	 * Default 5.
	 *
	 * @var int
	 */
	public int $redirection;

	/**
	 * Version of the HTTP protocol to use.
	 *
	 * Accepts '1.0' and '1.1'.
	 *
	 * Default '1.0'.
	 *
	 * @phpstan-var '1.0'|'1.1'
	 *
	 * @var string
	 */
	public string $httpversion;

	/**
	 * User-agent value sent.
	 *
	 * Default `'WordPress/' . get_bloginfo( 'version' ) . '; ' . get_bloginfo( 'url' )`.
	 *
	 * @var string
	 */
	public string $user_agent;

	/**
	 * Whether to pass URLs through `wp_http_validate_url()`.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $reject_unsafe_urls;

	/**
	 * Whether the calling code requires the result of the request.
	 *
	 * If set to false, the request will be sent to the remote server, and processing returned to the calling code immediately, the caller
	 * will know if the request succeeded or failed, but will not receive any response from the remote server.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $blocking;

	/**
	 * Array of headers to send with the request.
	 *
	 * Default empty array.
	 *
	 * @var array<string,string>
	 */
	public array $headers;

	/**
	 * List of cookies to send with the request.
	 *
	 * Default empty array.
	 *
	 * @var string[]|\WP_Http_Cookie[]
	 */
	public array $cookies;

	/**
	 * Body to send with the request.
	 *
	 * Default null.
	 *
	 * @var string|array
	 */
	public $body;

	/**
	 * Whether to compress the $body when sending the request.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $compress;

	/**
	 * Whether to decompress a compressed response.
	 *
	 * If set to false and compressed content is returned in the response anyway, it will need to be separately decompressed.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $decompress;

	/**
	 * Whether to verify SSL for the request.
	 *
	 * Default true.
	 *
	 * @var bool
	 */
	public bool $sslverify;

	/**
	 * Absolute path to an SSL certificate `.crt` file.
	 *
	 * Default `ABSPATH . WPINC . '/certificates/ca-bundle.crt'`.
	 *
	 * @var string
	 */
	public string $sslcertificates;

	/**
	 * Whether to stream to a file.
	 *
	 * If set to true and no filename was given, it will be droped it in the WP temp dir and its name will be set using the basename of the
	 * URL.
	 *
	 * Default false.
	 *
	 * @var bool
	 */
	public bool $stream;

	/**
	 * Filename of the file to write to when streaming. `$stream` must be set to true.
	 *
	 * Default null.
	 *
	 * @var string
	 */
	public string $filename;

	/**
	 * Size in bytes to limit the response to.
	 *
	 * Default null.
	 *
	 * @var int
	 */
	public int $limit_response_size;
}
