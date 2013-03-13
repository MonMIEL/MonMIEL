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
    public function get($keys)
    {
        $this->stopWatch->start("get", "dao");
        $days = $this->rteIndexBucket->fetch($keys)->getContents();
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
     * @DI\Inject("debug.stopwatch")
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;
}
