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
 * HttpResponse Class
 *
 * HttpResponse Class for handling response from Controller to HTTP response.
 *
 * @category Class
 * @package  EmailBlast\Modules\HttpResponse
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class HttpResponse
{
    
    /**
     * Init HttpResponse
     *
     * This function set default response headers
     *
     * @return void
     */
    public static function initHeaders()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }
    
    /**
     * Return internal server error response.
     *
     * @param string $message Error message to be logged.
     *
     * @return void
     */
    public static function sendErr($message)
    {
        // Log the error message
        error_log($message);

        // Return internal server error response
        self::initHeaders();
        http_response_code(500);
        echo json_encode(
            [
                "status" => "error",
                "message" => "Internal Server Error"
            ]
        );
        exit;
    }

    /**
     * Return bad request response.
     *
     * @param string $message Optional message for the bad request.
     *
     * @return void
     */
    public static function sendBadRequest($message = "")
    {
        self::initHeaders();
        http_response_code(400);
        echo json_encode(
            [
                "status" => "error",
                "message" => $message ?: "Bad Request"
            ]
        );
        exit;
    }

    /**
     * Return UrlNotFound response.
     *
     * @return void
     */
    public static function sendUrlNotFound()
    {
        self::initHeaders();
        http_response_code(404);
        echo json_encode(["status" => "url not found"]);
        exit;
    }

    /**
     * Return NotFound response.
     *
     * @return void
     */
    public static function sendNotFound()
    {
        self::initHeaders();
        http_response_code(200);
        echo json_encode(["status" => "not found"]);
        exit;
    }

    /**
     * Return Unauthorized response.
     *
     * @return void
     */
    public static function sendUnauthorized()
    {
        self::initHeaders();
        http_response_code(401);
        echo json_encode(["status" => "Unauthorized"]);
        exit;
    }

    /**
     * Return OK response.
     *
     * @return void
     */
    public static function sendOk()
    {
        self::initHeaders();
        http_response_code(200);
        echo json_encode(["status" => "ok"]);
        exit;
    }

    /**
     * Return JSON response.
     *
     * @param mixed $data Data to be returned.
     *
     * @return void
     */
    public static function sendOkWithData(array $data)
    {
        self::initHeaders();
        http_response_code(200);
        echo json_encode($data);
        exit;
    }
}
