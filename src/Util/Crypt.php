<?php
declare( strict_types=1 );

namespace Lipe\Lib\Util;

//phpcs:disable WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_decode
//phpcs:disable WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode

/**
 * Encrypt/Decrypt a string using a custom key.
 * Objects may be encrypted using `json_encode` or `serialize` first.
 *
 * Compatible with JS encryption/decryption via `crypto-js`.
 *
 * @link   https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
 *       Reference
 * @see    `js/src/helpers/crypt`
 */
class Crypt {
	protected const ALGORITHM  = 'sha512';
	protected const ITERATIONS = 999;

	/**
	 * Recommended AES-128-CBC, AES-192-CBC, AES-256-CBC
	 * due to there is no `openssl_cipher_iv_length()` function in JavaScript
	 * and these methods are known as 16 in iv_length.
	 */
	protected const METHOD = 'AES-256-CBC';

	/**
	 * The encryption key.
	 *
	 * @var string
	 */
	protected $key;


	/**
	 * Crypt constructor.
	 *
	 * @param string $key - The encryption key.
	 */
	final public function __construct( string $key ) {
		$this->key = $key;
	}


	/**
	 * Decrypt a string.
	 *
	 * @link         https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
	 *
	 * @noinspection ForgottenDebugOutputInspection
	 *
	 * @param string $message - The encrypted string that is base64 encoded.
	 *
	 * @return ?string
	 */
	public function decrypt( string $message ): ?string {
		try {
			$json = json_decode( (string) base64_decode( $message, true ), true, 512, JSON_THROW_ON_ERROR );
		} catch ( \JsonException $e ) {
			error_log( "Unable to decrypt message: {$message}. {$e->getMessage()}" ); //phpcs:ignore
			return null;
		}
		$iterations = (int) abs( $json['iterations'] ?? static::ITERATIONS );

		try {
			$salt = (string) hex2bin( $json['salt'] );
			$iv = (string) hex2bin( $json['iv'] );
			$hash_key = (string) hex2bin( hash_pbkdf2( static::ALGORITHM, $this->key, $salt, $iterations, $this->get_key_size() ) );
		} catch ( \Exception $e ) {
			error_log( "Unable to decrypt message: {$message}. {$e->getMessage()}" ); //phpcs:ignore
			return null;
		}

		return (string) openssl_decrypt( (string) base64_decode( $json['ciphertext'], true ), static::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv );
	}


	/**
	 * Encrypt a string.
	 *
	 * @link https://gist.github.com/ve3/0f77228b174cf92a638d81fddb17189d
	 *
	 * @param string $plaintext - The string to encrypt.
	 *
	 * @return ?string
	 */
	public function encrypt( string $plaintext ): ?string {
		try {
			$iv = random_bytes( max( 1, (int) openssl_cipher_iv_length( static::METHOD ) ) );
			$salt = random_bytes( 256 );
		} catch ( \Exception ) {
			return null;
		}

		$hash_key = (string) hex2bin( hash_pbkdf2( static::ALGORITHM, $this->key, $salt, static::ITERATIONS, $this->get_key_size() ) );

		$output = [
			'ciphertext' => base64_encode( (string) openssl_encrypt( $plaintext, static::METHOD, $hash_key, OPENSSL_RAW_DATA, $iv ) ),
			'iv'         => bin2hex( $iv ),
			'salt'       => bin2hex( $salt ),
			'iterations' => static::ITERATIONS,
		];
		unset( $iv, $salt, $hash_key );

		return base64_encode( (string) wp_json_encode( $output ) );
	}


	/**
	 * Get the key size based on the METHOD we are using.
	 *
	 * Strip all non-numeric characters from method and divide by 4.
	 *
	 * @notice This size is 4 times larger than the one used in `crypto-js`.
	 *
	 * @return int
	 */
	protected function get_key_size(): int {
		return preg_replace( '/\D/', '', static::METHOD ) / 4;
	}


	/**
	 * Check if a string has been previously encrypted.
	 *
	 * Does not validate the encryption key, use `decrypt` for that.
	 *
	 * @param string $data - A possibly encrypted string.
	 *
	 * @return bool
	 */
	public static function is_encrypted( string $data ): bool {
		$decoded = \base64_decode( $data, true );
		if ( false === $decoded || $decoded === $data ) {
			return false;
		}
		try {
			$array = json_decode( $decoded, true, 512, JSON_THROW_ON_ERROR );
		} catch ( \JsonException ) {
			return false;
		}
		if ( ! isset( $array['ciphertext'], $array['iv'], $array['salt'], $array['iterations'] ) ) {
			return false;
		}
		return true;
	}


	/**
	 * Crypt Factory.
	 *
	 * @param string $key - The encryption key.
	 *
	 * @return static
	 */
	public static function factory( string $key ): static {
		return new static( $key );
	}
}
