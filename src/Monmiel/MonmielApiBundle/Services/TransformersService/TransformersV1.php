<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersInterface;

/**
 * @DI\Service("monmiel.transformers.service")
 */
class TransformersV1 implements TransformersInterface
{

    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day $day
     */
    public function get($day)
    {
        // TODO: Implement get() method.
    }

    public function test() {
        $jour = $this->daoService->getDayConso(2);
    }

    /**
     * Transformer le total de la consommation donnee au total de la consommation theorique
     * @param array<Quarter> $listQuarter list des quarters à traiter
     * @param $consoAct     la consommation actuelle
     * @param $consoUser    la consommation saisie par utilisateur
     *
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */

     function transformeTotalToConsoTher($listQuarter,$consoAct,$consoUser)
     {

        // Definir une liste temporaire
        $tmp = array();

        // Parcourir la liste et transformer chaque conso en conso theorique
        foreach ($listQuarter as $value) {
            // Appliquer la formule de calcul
            $tmpVal= $this->transformeTotalCalcul($value->getConsoTotal(),$consoAct,$consoUser);

            echo "Test avant calcul" . "\n";
            echo $value->getConsoTotal() . "\n";

            // Remplacer la valeur par la nouvelle valeur

            echo "Test apres calcul" . "\n";
            echo $tmpVal . "\n";

            $value->setConsoTotal($tmpVal);

            $tmpValeur = $value;
            array_push($tmp,$tmpValeur);

        }
        // Affectation de la liste


        return $tmp;
    }


    /**
     * La methode utilisee pour calculer la transformation totale theorique
     * @param $totalActQuart  la consommation totale actuelle par quarter
     * @param $consoAct     la consommation actuelle
     * @param $consoUser    la consommation saisie par utilisateur
     * @return int
     */
    public function transformeTotalCalcul($totalActQuart,$consoAct,$consoUser){

        return ($totalActQuart* $consoUser)/$consoAct;

    }

    /**
     * @param $listQuarter
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */
    public function transformeLQuarterToLJourDAO($listQuarter){

    }

    /**
     * @DI\Inject("monmiel.dao.riak")
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    public $daoService;
}
