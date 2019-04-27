<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Kafka;

use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\ProducerTopic;

/**
 * Kafka 连接器
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class KafkaConnector
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var int
     */
    protected $sleepOnError;

    /**
     * @var Producer
     */
    private $producer;

    /**
     * @var KafkaConsumer
     */
    private $consumer;

    /**
     * @param Producer $producer
     * @param KafkaConsumer $consumer
     * @param array $config
     */
    public function __construct(Producer $producer, KafkaConsumer $consumer, $config)
    {
        $this->sleepOnError = isset($config['sleep_on_error']) ? $config['sleep_on_error'] : 5;
        $this->producer = $producer;
        $this->consumer = $consumer;
        $this->config = $config;
    }

    /**
     * Return a Kafka Topic based on the name
     *
     * @param $queue
     *
     * @return ProducerTopic
     */
    public function getTopic($queue)
    {
        return $this->producer->newTopic($queue);
    }
}