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

/**
 * Abstract Consumer Class
 * This abstract class serves as a base for creating consumer handler speisific.
 *
 * @category Class
 * @package  EmailBlast\App\Consumer
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
abstract class Consumer
{
    /**
     * Handle the request.
     *
     * This method must be implemented by any class that extends BaseHandler.
     *
     * @param mixed $message is message from nsq
     *
     * @return mixed The result of handling the Consumer.
     */
    abstract protected function handle($message);
}
