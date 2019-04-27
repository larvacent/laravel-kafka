<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Kafka\Queue;

use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\TopicConf;

/**
 * Class KafkaServiceProvider
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class KafkaServiceProvider extends ServiceProvider
{
    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__ . '/../config/kafka.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('kafka.php'),
            ], 'kafka-config');
        }

        $this->mergeConfigFrom($source, 'kafka');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {

        $this->setupConfig();

        $this->app->singleton('kafka', function ($app) {
            $config = config('kafka');
            /** @var Producer $producer */
            $producer = new Producer();
            $producer->addBrokers($config['brokers']);

            /** @var TopicConf $topicConf */
            $topicConf = new TopicConf();
            $topicConf->set('auto.offset.reset', 'largest');

            /** @var Conf $conf */
            $conf = new Conf;
            $conf->set('metadata.broker.list', $config['brokers']);
            foreach ($config['defaultConf'] as $key => $val) {
                $conf->set($key, $val);
            }
            $conf->setDefaultTopicConf($topicConf);

            /** @var KafkaConsumer $consumer */
            $consumer = new KafkaConsumer($conf);

            return new KafkaConnector($producer, $consumer, $config);
        });
    }
}