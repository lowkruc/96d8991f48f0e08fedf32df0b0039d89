<?php
/**
 * EmailBlast Namespace
 * This namespace contains classes specific to the EmailBlast Rest API.
 *
 * PHP version 8.2
 *
 * @category Bootstrap
 * @package  Index
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
require_once __DIR__ . '/vendor/autoload.php';

use EmailBlast\Consumers\MailerConsumer;
use EmailBlast\Modules\NsqModule;

// Intialize URI without Auth
// $bypassURI = ["/ping", "/login"];

// initalize NsqModule
$nsq = new NsqModule();

// Register Nsq Consumer
$nsq->addConsumer(
    "tcp://nsq-service.asemedia.tech:4150",
    "worker_mailer",
    "php_mailer_handler",
    [new MailerConsumer(), 'handle']
);