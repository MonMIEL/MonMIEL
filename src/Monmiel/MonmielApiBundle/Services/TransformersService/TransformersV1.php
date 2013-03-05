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


    /**
     * <code>
     * @include \Monmiel\MonmielApiModelBundle\Model\Quarter.php
     * </code>
     *
     * @param $listQuarter  list des quarters à traiter
     * @param $consoAct     la consommation actuelle
     * @param $consoUser    la consommation saisie par utilisateur
     *
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */

     function transformeTotalToConsoTher(array $listQuarter,$consoAct,$consoUser){



        foreach ($listQuarter as $value) {




        }


    }


    /**
     * @param $listQuarter
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Jour_DAO>
     */
    public function transformeLQuarterToLJourDAO($listQuarter){


    }








}
