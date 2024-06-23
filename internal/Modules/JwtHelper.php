<?php
/**
 * EmailBlast\Modules Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Class
 * @package  EmailBlast\Modules
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
namespace EmailBlast\Modules;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Jwt Class
 *
 * This slass for jwt helper.
 *
 * @category Class
 * @package  EmailBlast\Modules\Jwt
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class JwtHelper {
    private static string $secretKey = 'randomtest123'; // Secret key for JWT

    /**
     * GenerateToken
     *
     * This function to generate JWT Token from payload
     *
     * @param array $payload payload jwt
     *
     * @return void
     */
    public static function generateToken(array $payload): string {
        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    /**
     * DecodeToken
     *
     * This function to decode JWT Token to payload
     *
     * @param string $token token jwt
     *
     * @return void
     */
    public static function decodeToken(string $token): ?object {
        try {
            $key = new Key(self::$secretKey, 'HS256');
            return JWT::decode($token, $key);
        } catch (\Exception $e) {
            return null;
        }
    }
}