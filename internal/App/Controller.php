<?php
/**
 * EmailBlast\App Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\App
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */

namespace EmailBlast\App;

use EmailBlast\Modules\HttpResponse;

/**
 * Abstract Controller Class
 * This abstract class serves as a base for creating controller speisific.
 *
 * @category Class
 * @package  EmailBlast\App\Middleware
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
abstract class Controller
{
    /**
     * Init HttpResponse
     *
     * This function set default response headers
     *
     * @return void
     */
    public function __construct()
    {
        // init headers response
        // TODO: init another service or modules
    }
    

    /**
     * SendError.
     *
     * This method to send error response.
     *
     * @param string $message message value error
     *
     * @return mixed
     */
    public function sendError(string $message)
    {
        return HttpResponse::sendErr($message);
    }
    
    /**
     * SendBadRequest.
     *
     * This method to send bad request response.
     *
     * @param string $message message value error
     *
     * @return mixed
     */
    public function sendBadRequest(string $message)
    {
        return HttpResponse::sendBadRequest($message);
    }

    /**
     * SendError.
     *
     * This method to send not found response.
     *
     * @return mixed
     */
    public function sendNotFound()
    {
        return HttpResponse::sendNotFound();
    }

    /**
     * SendOk.
     *
     * This method to send ok response.
     *
     * @return mixed
     */
    public function sendOk()
    {
        return HttpResponse::sendOk();
    }

    /**
     * SendOkWithData.
     *
     * This method to send ok with data response.
     *
     * @param array $result is result response.
     *
     * @return mixed
     */
    public function sendOkWithData(array $result)
    {
        return HttpResponse::sendOkWithData($result);
    }
}
