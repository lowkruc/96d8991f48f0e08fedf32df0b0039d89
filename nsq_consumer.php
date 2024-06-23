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

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// initalize NsqModule
$nsq = new NsqModule();

// Register Nsq Consumer
$nsq->addConsumer(
    sprintf("tcp://%s:%s", $_ENV["nsq_host"], $_ENV["nsq_port"]),
    $_ENV["nsq_topic_mailer"],
    $_ENV["nsq_channel_mailer_consumer"],
    [new MailerConsumer(), 'handle']
);