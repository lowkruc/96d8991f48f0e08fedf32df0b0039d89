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
use Amp\Loop;
use Amp\Promise;
use Nsq\Config\ClientConfig;
use Nsq\Producer;
use function Amp\call;
use Nsq\Consumer;
use Nsq\Message;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * NsqModule Class
 *
 * This class for nsq module.
 *
 * @category Class
 * @package  EmailBlast\Modules\NsqModule
 * @author   Ahmad Saekoni <asemediatech@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/lowkruc/96d8991f48f0e08fedf32df0b0039d89
 */
class NsqModule
{
    protected $nsqdHost = "http://nsq-service.asemedia.tech:4151";
    protected $consumers = [];

    /**
     * Construct NsqModule
     *
     * This function for construct NsqModule
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * AddConsumer
     *
     * This function for add consumer
     *
     * @param string   $nsqdHost host:port nsq
     * @param string   $topic    topic consumer
     * @param string   $channel  channel consumer
     * @param callable $handler  handler consumer
     *
     * @return void
     */
    public function addConsumer(
        string $nsqdHost,
        string $topic,
        string $channel,
        callable $handler
    ) {
        $logger = new Logger('nsq_logger');
        $logger->pushHandler(
            new StreamHandler("./log/consumer/$channel.log", Logger::DEBUG)
        );

        Loop::run(
            static function () use ($nsqdHost, $topic, $channel, $handler, $logger) {
                try {
                    $consumer = new Consumer(
                        $nsqdHost,
                        topic: $topic,
                        channel: $channel,
                        onMessage:
                        static function (Message $message) use ($handler): Promise {
                            return call(
                                function () use ($message, $handler): \Generator {
                                    yield $message->touch();
                                
                                    // nosec
                                    try {
                                        $handler($message);
                                    } catch (\Throwable $th) {
                                        yield $message->requeue(timeout: 5000);
                                    }
            
                                    yield $message->finish();
                                }
                            );
                        },
                        clientConfig: new ClientConfig(
                            deflate: false,
                            snappy: false,
                        ),
                        logger: $logger,
                    );

                    yield $consumer->connect();
                } catch (\Throwable $e) {
                    $logger->error('Error in consumer: {error}', ['error' => $e->getMessage()]);
                }
            }
        );
    }

    /**
     * Publish
     *
     * This function for publish message
     *
     * @param array  $message is message to publish
     * @param string $nsqhost is nsqhost
     * @param string $topic   is topic to publish
     *
     * @return void
     */
    public function publish(array $message, string $nsqhost, string $topic)
    {
        $logger = new Logger('nsq_logger');
        $logger->pushHandler(
            new StreamHandler("./log/consumer/producer.log", Logger::DEBUG)
        );

        Loop::run(
            static function () use ($logger, $nsqhost, $topic, $message) {
                $producer = new Producer(
                    $nsqhost,
                    clientConfig: new ClientConfig(
                        deflate: false,
                        heartbeatInterval: 5000,
                        snappy: false,
                    ),
                    logger: $logger,
                );
            
                yield $producer->connect();
            
                while (true) {
                    try {
                        $jsonString = json_encode($message);
                        yield $producer->publish(topic: $topic, body: $jsonString);
                    } catch (\Throwable $e) {
                        $logger->error('Failed to publish message: ' . $e->getMessage());
                    }

                    $producer->close();
                    break;
                }
            }
        );
    }
}
