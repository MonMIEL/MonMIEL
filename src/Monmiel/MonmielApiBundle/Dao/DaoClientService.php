<?php

namespace Monmiel\MonmielApiBundle\Dao;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiBundle\Dao\RiakDao;

use Monmiel\MonmielApiModelBundle\Model\Day;
/**
 * @DI\Service("monmiel.dao.client")
 */
class DaoClientService
{
    const BUFFER_SIZE = 10;

    /**
     * @var $dao RiakDao
     * @DI\Inject("monmiel.dao.riak")
     */
    public $dao;

    /**
     * @var $dayBuffer array<Day>
     */
    protected $dayBuffer = array();

    /**
     * @param $dayNumber integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($dayNumber)
    {
        $this->stopWatch->start("createDate", "dao client");
        $date = date_create_from_format("Y-m-d", "2011-01-01");
        $date->modify("+".($dayNumber-1)." day");
        $key = $date->format("Y-m-d");
        $this->stopWatch->stop('createDate');
        $this->stopWatch->start("retrieve Days", "dao client");
        if (! $this->isInBuffer($key)) {
            $this->updateBuffer($date);
        }
        $this->stopWatch->stop("retrieve Days");



        return $this->dayBuffer[$key];
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

    public function isInBuffer($key)
    {
        return array_key_exists($key, $this->dayBuffer);
    }

    public function updateBuffer($dateTime)
    {
        $keys = $this->createKeys($dateTime);
        $days = $this->dao->get($keys);
        $dayBuffer = array();
        /** @var $day Day */
        foreach ($days as $day) {
            $dayBuffer[$day->getKey()] = $day;
        }

        $this->setDayBuffer($dayBuffer);
    }

    /**
     * @DI\Inject("debug.stopwatch")
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @param array $dayBuffer
     */
    public function setDayBuffer($dayBuffer)
    {
        $this->dayBuffer = $dayBuffer;
    }

    /**
     * @return array
     */
    public function getDayBuffer()
    {
        return $this->dayBuffer;
    }
}
