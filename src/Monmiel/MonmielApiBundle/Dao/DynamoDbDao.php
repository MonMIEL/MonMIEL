<?php

namespace Monmiel\MonmielApiBundle\Dao;

use JMS\DiExtraBundle\Annotation as DI;
use Riverline\DynamoDB\Connection;
use Riverline\DynamoDB\Item;
use Aws\Common\Enum\Region;

/**
 * @DI\Service("monmiel.dao.dynamo")
 */
class DynamoDbDao implements DaoInterface
{
    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function gets($keys)
    {
        $this->stopWatch->start("gets", "dao");
        $days = $this->rteIndexBucket->fetch($keys)->getContents();
        $this->stopWatch->stop('gets');
        return $days;
    }

    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($key)
    {
        $this->stopWatch->start("get", "dao");
        $days = $this->rteIndexBucket->uniq($key)->getContent();
        $this->stopWatch->stop('get');
        return $days;
    }

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return mixed bool
     */
    public function put($day)
    {
        $this->rteIndexBucket->put(array($day->getKey() => $day));
    }

    public function createConnection()
    {
        $connectionEU = new Connection($this->accessKey, $this->secretKey, Region::EU_WEST_1);

// Attach a simple logger (or write your own logger class)
        $connection->setLogger(new \Riverline\DynamoDB\Logger\EchoLogger());
    }

    /**
     * @DI\InjectParams({
     *     "riakCluster" = @DI\Inject("riak.cluster.monmiel")
     * })
     */
    public function __construct($riakCluster)
    {
        $this->rteIndexBucket = $riakCluster->getBucket("rte_index");
    }

    /**
     * @DI\Inject("debug.stopwatch")
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @DI\Inject("serializer")
     * @var \JMS\Serializer\Serializer $serializer
     */
    public $serializer;

    /**
     * @var string
     * @DI\Inject("%dynamo_accesskey%")
     */
    public $accessKey;

    /**
     * @var string
     * @DI\Inject("%dynamo_secretkey%")
     */
    public $secretKey;
}
