<?php
/**
 * EmailBlast\Controller Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Namespace
 * @package  EmailBlast\Controller
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
namespace EmailBlast\Controllers;
use EmailBlast\App\Controller;
use EmailBlast\Models\UserModel;
use EmailBlast\Modules\JwtHelper;
use EmailBlast\Modules\NsqModule;
use EmailBlast\Modules\RequestParser;
use stdClass;

/**
 * EmailController Class
 * This Class for handling request email controller.
 *
 * @category Class
 * @package  EmailBlast\Controller\EmailController
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class EmailController extends Controller
{
    protected $nsq;

    /**
     * Constructor AuthController
     *
     * This function constructor for AuthController
     */
    public function __construct()
    {
        $this->nsq = new NsqModule();
    }

    /**
     * Handle POST login
     *
     * This function for user login to get access token
     *
     * @return void
     */
    public function sendEmail()
    {
        try {
            $request = RequestParser::parseJsonRequestBody(false);
       
            $recipient = $request->recipient;
            $subject = $request->subject;
            $body = $request->body;

            if ($recipient == "" || $subject == "" || $body == "") {
                return $this->sendBadRequest(
                    "username or password and body must be filled"
                );
            }

            $message[] =  array(
                "recipient" => $recipient,
                "subject" => $subject,
                "body" => $body
            );
            $this->nsq->publish(
                $message,
                sprintf("tcp://%s:%s", $_ENV["nsq_host"], $_ENV["nsq_port"]),
                $_ENV["nsq_topic_mailer"]
            );
        } catch (\Throwable $th) {
            return $this->sendError($th);
        }

        $this->sendOk();
    }
}
