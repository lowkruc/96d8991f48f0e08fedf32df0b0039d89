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
 * MailModel Class
 * This class for mail model.
 *
 * @category Class
 * @package  EmailBlast\Models\UserModel
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class MailModel extends Model
{
    protected $table = "emails";

    /**
     * GetUserByUsernameAndPassword.
     *
     * This function to get user data by username and password.
     *
     * @param string $recipient recipient email
     * @param string $subject   subject email
     * @param string $body      body email
     *
     * @return bool
     */
    public function insertMail(string $recipient, string $subject, string $body): bool
    {
        return $this->db->table($this->table)->insert(
            array(
                "email" => $recipient,
                "subject" => $subject,
                "body" => $body,
                "status" => "send"
            )
        );
    }
}