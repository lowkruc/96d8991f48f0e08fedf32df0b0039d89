<?php
/**
 * EmailBlast\Consumers Namespace
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

namespace EmailBlast\Consumers;
use EmailBlast\App\Consumer;
use EmailBlast\Models\MailModel;
use EmailBlast\Models\UserModel;
use EmailBlast\Modules\Mailer;
/**
 * MailerConsumer Class
 * This class for consumer mailer handler.
 *
 * @category Class
 * @package  EmailBlast\Middlewares\MailerConsumer
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class MailerConsumer extends Consumer
{
    protected $mailer = null;
    protected $mailModel = null;

    /**
     * Construct MailerConsumer
     *
     * This function for construct MailerConsumer
     *
     * @return void
     */
    public function __construct()
    {
        $this->mailer = new Mailer();
        $this->mailModel = new MailModel();
    }
    
    /**
     * Handle Middleware
     *
     * This function for handle middleware logic
     *
     * @param mixed $message is message from nsq
     *
     * @return mixed
     */
    public function handle($message)
    {
        try {
            $arrayMails = json_decode($message->body, true);
            if (empty($arrayMails) || !is_array($arrayMails)) {
                error_log(sprintf("empty message: %s", $arrayMails));
                return;
            }

            foreach ($arrayMails as $mail) {
                $errArry = [];
                if (!isset($mail["recipient"]) || $mail["recipient"] === "") {
                    $errArry[] = "Recipient is required";
                }

                if (!isset($mail["subject"]) || $mail["subject"] === "") {
                    $errArry[] = "Subject is required";
                }

                if (!isset($mail["body"]) || $mail["body"] === "") {
                    $errArry[] = "Body is required";
                }

                if (!empty($errArry)) {
                    error_log(sprintf("invalid body mesasge: %s", $message->body));
                    return;
                }

                // send email
                $ok = $this->mailer->send($mail['recipient'], $mail['subject'], $mail['body']);

                // insert to db
                if ($ok) {
                    $success = $this->mailModel->insertMail($mail['recipient'], $mail['subject'], $mail['body']);
                    if (!$success) {
                        return error_log("error inset mail");
                    }
                }
            }
        } catch (\Throwable $th) {
            error_log($th);
        }
    }
}
