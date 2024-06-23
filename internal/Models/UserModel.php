<?php
/**
 * EmailBlast\Models Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\Middlewares
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */

namespace EmailBlast\Models;
use EmailBlast\App\Model;
/**
 * UserModel Class
 * This class for user model.
 *
 * @category Class
 * @package  EmailBlast\Models\UserModel
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class UserModel extends Model
{
    protected $table = "users";

    /**
     * GetUserByUsernameAndPassword.
     *
     * This function to get user data by username and password.
     *
     * @param string $username username
     * @param string $password password
     *
     * @return array
     */
    public function getUserByUsernameAndPassword(string $username, string $password)
    {
        $hashPassword = md5($password);
        return $this->db->table($this->table)->where("username", "=", $username)->where("password", "=", $hashPassword)->first();
    }

    /**
     * GetUserByUsernameAndPassword.
     *
     * This function to get user data by username and password.
     *
     * @param string $name     name
     * @param string $username username
     * @param string $password password
     *
     * @return bool
     */
    public function createUser(string $name, string $username, string $password)
    {
        $hashPassword = md5($password);
        return $this->db->table($this->table)->insert(
            array(
                "name" => $name,
                "username" => $username,
                "password" => $hashPassword
            )
        );
    }

    /**
     * GetUserByUsername.
     *
     * This function to get user data by username.
     *
     * @param string $username username
     *
     * @return array
     */
    public function getUserByUsername(string $username)
    {
        return $this->db->table($this->table)->where("username", "=", $username)->first();
    }

}