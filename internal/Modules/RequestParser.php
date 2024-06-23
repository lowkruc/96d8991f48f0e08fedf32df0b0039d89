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

/**
 * RequestParser Class
 *
 * RequestParser Class for parsing request body from HTTP request.
 *
 * @category Class
 * @package  EmailBlast\Modules\RequestParser
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class RequestParser
{
    /**
     * Parse JSON request body to associative array or object.
     *
     * @param bool $assoc When TRUE, returned objects will be converted into associative arrays.
     *
     * @return mixed Returns the value encoded in JSON in appropriate PHP type.
     * @throws \Exception If the JSON cannot be decoded or if the encoded data is deeper than the recursion limit.
     */
    public static function parseJsonRequestBody(bool $assoc = true)
    {
        // Ensure the Content-Type is application/json
        if (!isset($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            throw new \Exception('Content-Type must be application/json');
        }

        // Read the request body
        $input = file_get_contents('php://input');

        // Decode the JSON input
        $data = json_decode($input, $assoc);

        // Handle JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON: ' . json_last_error_msg());
        }

        return $data;
    }
}