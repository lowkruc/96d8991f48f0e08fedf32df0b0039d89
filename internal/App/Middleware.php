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
 * Abstract Middleware Class
 * This abstract class serves as a base for creating middleware speisific.
 *
 * @category Class
 * @package  EmailBlast\App\Middleware
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
abstract class Middleware
{
    /**
     * Handle the request.
     *
     * This method must be implemented by any class that extends BaseHandler.
     *
     * @return mixed The result of handling the middelware.
     */
    abstract protected function handle();
}
