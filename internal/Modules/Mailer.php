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
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Mailer Class
 *
 * This class for mailer.
 *
 * @category Class
 * @package  EmailBlast\Modules\Mailer
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class Mailer
{
    protected $mail = null;

    /**
     * Construct Mailer
     *
     * This function for construct Mailer
     *
     * @return void
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = $_ENV["smtp_host"];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $_ENV["smtp_username"];
        $this->mail->Password = $_ENV["smtp_password"];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $_ENV["smtp_port"];
    }

    /**
     * Send
     *
     * This function to send email
     *
     * @param string $recipient email recipient
     * @param string $subject   subject message
     * @param string $body      body message
     *
     * @return void
     */
    public function send(string $recipient, string $subject, string $body): bool
    {
        try {
            $this->mail->setFrom(
                $_ENV["smtp_sender_email"],
                $_ENV["smtp_sender_name"]
            );
            $this->mail->addAddress($recipient);
            $this->mail->isHTML(false);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            return $this->mail->send();

        } catch (\Throwable $th) {
            throw new \Exception($th);
        }
    }

}