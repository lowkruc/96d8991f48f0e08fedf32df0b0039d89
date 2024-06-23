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
 * Abstract Model Class
 * This abstract class serves as a base for creating model speisific.
 *
 * @category Class
 * @package  EmailBlast\App\Model
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
abstract class Model
{
    protected Database $db;

    /**
     * Construct Model.
     *
     * This construct is initial datbaase and more repository.
     */
    public function __construct() 
    {
        $this->db = new Database();
    }
}
