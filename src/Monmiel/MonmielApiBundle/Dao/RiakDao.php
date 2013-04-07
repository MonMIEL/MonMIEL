<?php

namespace Monmiel\MonmielApiBundle\Dao;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.dao.riak")
 */
class RiakDao implements DaoInterface
{
    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function gets($keys)
    {
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("gets", "dao");
        }
        $days = $this->rteIndexBucket->fetch($keys)->getContents();
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop('gets');
        }
        return $days;
    }

    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($key)
    {
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("get", "dao");
        }
        $days = $this->rteIndexBucket->uniq($key)->getContent();
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop('get');
        }
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
     * @var \Kbrw\RiakBundle\Model\Bucket\Bucket
     */
    public $rteIndexBucket;

    /**
     * @DI\Inject("debug.stopwatch", required=false)
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @DI\Inject("serializer")
     * @var \JMS\Serializer\Serializer $serializer
     */
    public $serializer;
}
