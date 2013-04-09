<?php

namespace Monmiel\MonmielApiBundle\Dao;

use Doctrine\Common\Cache\ApcCache;
use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Day;

/**
 * @DI\Service("monmiel.dao.client")
 */
class DaoClientService
{
    const BUFFER_SIZE = 5;

    /**
     * @var $dao DynamoDbDao
     * @DI\Inject("monmiel.dao.dynamo")
     */
    public $dao;

    function __construct()
    {
        $this->apc = new ApcCache();
    }

    /**
     * @param $dayNumber integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function gets($dayNumber)
    {
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("createDate", "dao client");
        }
        $date = date_create_from_format("Y-m-d", "2011-01-01");
        $date->modify("+".($dayNumber-1)." day");
        $key = $date->format("Y-m-d");
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop('createDate');
        }
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("retrieve Days", "dao client");
        }
        if (! $this->isInCache($key)) {
            $this->updateCache($date);
        }
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop("retrieve Days");
        }

        return $this->apc->fetch($key);
    }

    /**
     * @param $dayNumber integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($dayNumber)
    {
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("createDate", "dao client");
        }
        $date = date_create_from_format("Y-m-d", "2011-01-01");
        $date->modify("+".($dayNumber-1)." day");
        $key = $date->format("Y-m-d");
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop('createDate');
        }

        return $this->dao->get($key);
    }

    /**
     * @param $dateTime \DateTime
     */
    public function createKeys($dateTime)
    {
        $keys = array();
        for ($i = 0; $i < DaoClientService::BUFFER_SIZE; $i++) {
            $keys[] = $dateTime->format("Y-m-d");
            $dateTime->modify("+1 day");
        }

        return $keys;
    }

    public function isInCache($key)
    {
        return $this->apc->contains($key);
    }

    public function updateCache($dateTime)
    {
        $keys = $this->createKeys($dateTime);
        $days = $this->dao->gets($keys);
        /** @var $day Day */
        foreach ($days as $day) {
            $this->apc->save($day->getKey(), $day);
        }
    }

    /**
     * @DI\Inject("debug.stopwatch", required=false)
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @var ApcCache $apc
     */
    protected $apc;
}
