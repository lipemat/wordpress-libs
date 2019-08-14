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
 * @link https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
 *       Reference
 *
 */
class Crypt {

	private $key;

	private const ALGORITHM  = 'sha512';
	private const METHOD     = 'AES-256-CBC';
	private const ITERATIONS = 999;


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
			$hash_key = hex2bin( hash_pbkdf2( self::ALGORITHM, $this->key, $salt, self::ITERATIONS, $this->get_key_size() ) );
		} catch ( \Exception $e ) {
			return null;
		}

		return openssl_decrypt( base64_decode( $json['ciphertext'] ), self::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv );
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
		$iv   = openssl_random_pseudo_bytes( openssl_cipher_iv_length( self::METHOD ) );
		$salt = openssl_random_pseudo_bytes( 256 );

		if ( false === $salt || false === $iv ) {
			return null;
		}

		$hash_key = hex2bin( hash_pbkdf2( self::ALGORITHM, $this->key, $salt, self::ITERATIONS, $this->get_key_size() ) );

		$output = [
			'ciphertext' => base64_encode( openssl_encrypt( $string, self::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv ) ),
			'iv'         => bin2hex( $iv ),
			'salt'       => bin2hex( $salt ),
			'iterations' => self::ITERATIONS,
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
		return (int) abs( filter_var( self::METHOD, FILTER_SANITIZE_NUMBER_INT ) ) / 4;
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
