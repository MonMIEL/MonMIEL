<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.transformers.service")
 */
class TransformersV1
{
    public function test() {
        $jour = $this->daoService->getDayConso(2);
    }

    /**
     * @DI\Inject("monmiel.dao.riak")
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    public $daoService;
}
