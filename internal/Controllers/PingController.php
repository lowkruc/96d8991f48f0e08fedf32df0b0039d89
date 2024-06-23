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
use EmailBlast\Modules\NsqModule;

/**
 * PingController Class
 * This Class for handling request ping controller.
 *
 * @category Class
 * @package  EmailBlast\Controller\PingController
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class PingController extends Controller
{
    protected NsqModule $nsq;
    /**
     * Constructor PingController
     *
     * This function constructor for PingController
     */
    public function __construct()
    {
        $this->nsq = new NsqModule();
    }

    /**
     * Handle GET ping
     *
     * This function for check health
     *
     * @return mixed
     */
    public function ping()
    {
        $this->nsq->publish(array("test" => "kampret keren"), "tcp://nsq-service.asemedia.tech:4150", "worker_mailer");
        $this->sendOkWithData(
            array(
                "status" => "ok",
                "online" => true,
                "date" => date("Y-m-d H:i:s")
            )
        );
    }
}
