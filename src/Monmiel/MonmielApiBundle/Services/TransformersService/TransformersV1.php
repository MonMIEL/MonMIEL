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
     * Transformer le total de la consommation donnee au total de la consommation theorique
     * @param array|\Monmiel\MonmielApiBundle\TransformersService\array $listQuarter list des quarters à traiter
     * @param $consoAct     la consommation actuelle
     * @param $consoUser    la consommation saisie par utilisateur
     *
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */

    public function transformeTotalToConsoTher(array $listQuarter,$consoAct,$consoUser){

        // Definir une liste temporaire
        $tmp = array();

        // Parcourir la liste et transformer chaque conso en conso theorique
        foreach ($listQuarter as $value) {
            // Appliquer la formule de calcul
            $tmpVal= ($value->getConsoTotal() * $consoUser)/$consoAct;
            // Remplacer la valeur par la nouvelle valeur
            $value->setConsoTotal($tmpVal);
        }
        // Affectation de la liste
        $tmp = $listQuarter;

        return $listQuarter;


    }


    /**
     * @param $listQuarter
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Jour_DAO>
     */
    public function transformeLQuarterToLJourDAO($listQuarter){


    }








}
