<?php

namespace Monmiel\MonmielApiBundle\Dao;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.dao.riak")
 */
class RiakDao
{
    /**
     * @param $jour integer
     * @return string
     */
    public function getDayConso($jour)
    {
        return "toto";
    }
}
