<?php

namespace Monmiel\MonmielApiBundle\TransformersService;

/**
 * @DI\Service("monmiel.transformers")
 */
class TransformersV1
{
    public function test() {
        $this->daoService->getDayConso("2");
    }

    /**
     * @DI\Inject("monmiel.dao.riak")
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    public $daoService;
}
