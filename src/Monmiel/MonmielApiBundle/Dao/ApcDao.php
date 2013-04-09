<?php

namespace Monmiel\MonmielApiBundle\Dao;

use Doctrine\Common\Cache\ApcCache;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.dao.apc")
 */
class ApcDao implements DaoInterface
{
    /**
     * @param $key string
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($key)
    {
        return $this->apc->fetch($key);
    }

    /**
     * @param $key string
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function gets($key)
    {
        $this->get($key);
    }

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return mixed bool
     */
    public function put($day)
    {
        echo "put ". $day->getKey()."\n";
        $this->apc->save($day->getKey(), $day);
    }

    /**
     *
     */
    public function __construct()
    {
        $this->apc = new ApcCache();
    }

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

    /**
     * @var ApcCache
     */
    public $apc;
}
