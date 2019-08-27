<?php

namespace Lipe\Lib\Util;

/**
 * Encrypt/Decrypt a string using a custom key.
 * Objects may be encrypted using `json_encode` or `serialize` first.
 *
 * Compatible with JS encryption/decryption via `crypto-js`.
 *
 * @since  2.12.0
 *
 * @link   https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
 *       Reference
 * @see `js/src/helpers/crypt`
 *
 */
class Crypt {
	protected const ALGORITHM  = 'sha512';
	protected const ITERATIONS = 999;

	/**
	 * Recommended AES-128-CBC, AES-192-CBC, AES-256-CBC
	 * due to there is no `openssl_cipher_iv_length()` function in JavaScript
	 * and all of these methods are known as 16 in iv_length.
	 */
	protected const METHOD = 'AES-256-CBC';

	/**
	 * @var string The encryption key.
	 */
	protected $key;


	/**
	 * Crypt constructor.
	 *
	 * @param string $key - The encryption key.
	 */
	public function __construct( string $key ) {
		$this->key = $key;
	}


	/**
	 * Decrypt string.
	 *
	 * @link   https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
	 *
	 * @param string $message - The encrypted string that is base64 encoded.
	 *
	 * @return string
	 */
	public function decrypt( string $message ) : ?string {
		$json = json_decode( base64_decode( $message ), true );

		try {
			$salt     = hex2bin( $json['salt'] );
			$iv       = hex2bin( $json['iv'] );
			$hash_key = hex2bin( hash_pbkdf2( static::ALGORITHM, $this->key, $salt, static::ITERATIONS, $this->get_key_size() ) );
		} catch ( \Exception $e ) {
			return null;
		}

		return openssl_decrypt( base64_decode( $json['ciphertext'] ), static::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv );
	}


	/**
	 * Encrypt string.
	 *
	 * @link https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public function encrypt( string $string ) : ?string {
		try {
			$iv   = random_bytes( openssl_cipher_iv_length( static::METHOD ) );
			$salt = random_bytes( 256 );
		} catch ( \Exception $e ) {
			return null;
		}

		$hash_key = hex2bin( hash_pbkdf2( static::ALGORITHM, $this->key, $salt, static::ITERATIONS, $this->get_key_size() ) );

		$output = [
			'ciphertext' => base64_encode( openssl_encrypt( $string, static::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv ) ),
			'iv'         => bin2hex( $iv ),
			'salt'       => bin2hex( $salt ),
			'iterations' => static::ITERATIONS,
		];
		unset( $encrypted, $iterations, $iv, $salt, $hash_key );

		return base64_encode( json_encode( $output ) );
	}


	/**
	 * Get the key size based on the METHOD we are using.
	 *
	 * @notice This size is 8 times larger than the one used in `crypto-js`.
	 *
	 * @return int
	 */
	protected function get_key_size() : int {
		return (int) abs( filter_var( static::METHOD, FILTER_SANITIZE_NUMBER_INT ) ) / 4;
	}


	/**
	 * Crypt Factory.
	 *
	 * @param string $key - The encryption key
	 *
	 * @return static
	 */
	public static function factory( string $key ) {
		return new static( $key );
	}
}
