<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Kafka;

use Illuminate\Support\Facades\Facade;

/**
 * Class Kafka
 * @mixin KafkaConnector
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Kafka extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kafka';
    }
}