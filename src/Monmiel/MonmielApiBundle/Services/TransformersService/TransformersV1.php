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
     * Injection of the RiakDao
     * @DI\Inject("monmiel.dao.riak")
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    public $riakDao;


    /**
     * the consommation in 2050
     * @var \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    protected  $consoInput;

    /**
     * the actual consommation
     * @var \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    protected  $consoActual;


    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day $day
     */
    public function get($day)
    {
        $consoDay = $this->riakDao->getDayConso($day);
        return $this->getTotalUpdated($consoDay);
    }
    /**
     * update the conso total for the Quarters of the Day in parameter with the actual conso and the input Coson
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function updateConsoTotalForDayWithActualConsoAndInputConso($day, $actualConso, $inputConso){
        $this->setConsoActual($actualConso);
        $this->setConsoInput($inputConso);
        return $this->getTotalUpdated($day);
    }


    /**
     * get the Day with the Quarters updated by Day Id,actual conso and the input Conso
     * @param $dayId integer
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function getDayUpdatedByDayIdActualConsoAndInputConso($dayId, $actualConso, $inputConso){
        $this->setConsoActual($actualConso);
        $this->setConsoInput($inputConso);
        $dayTemp = $this->riakDao->getDayConso($dayId);
        return $this->getTotalUpdated($dayTemp);
    }

    /**
     * update sum of the list of Quarter of Day  by the current consommation and the new consommation
     * @param $consoDay \Monmiel\MonmielApiModelBundle\Model\Day
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    private function getTotalUpdated($consoDay)
    {
        $retour = new \Monmiel\MonmielApiModelBundle\Model\Day($consoDay->getDateTime());
        if(isset($consoDay)){
            $cActuel = $this->getConsoActual();
            $cInput = $this->getConsoInput();
            if(\Monmiel\MonmielApiModelBundle\Model\Mesure::isEqualsMesure($cActuel,$cInput)){
                $array =  $this->transformeTotalToConsoTher($consoDay->getQuarters(),$cActuel,$cInput);
                $retour->setQuarters($array);
            }
            else{
                $consoInputConverted = \Monmiel\MonmielApiModelBundle\Model\Mesure::convertMesureByOtherUnitOfMesure($cInput,$cActuel->getUnitOfMesure());
                $array =  $this->transformeTotalToConsoTher($consoDay->getQuarters(),$this->getConsoActual(), $consoInputConverted);
                $retour->setQuarters($array);
                echo "------ different mesure \n -------";
            }
        }
        return $retour;
    }

    /**
     * Transformer le total de la consommation donnee au total de la consommation theorique
     * @param $listQuarter array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     * @param $consoAct \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $consoUser \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */

     private function transformeTotalToConsoTher($listQuarter,$consoAct,$consoUser)
     {
        // Definir une liste temporaire
        $tmp = array();
        // Parcourir la liste et transformer chaque conso en conso theorique
        foreach ($listQuarter as $value) {
            // Appliquer la formule de calcul

            $tmpVal= $this->transformeTotalCalcul($value->getConsoTotal(),$consoAct->getValue(),$consoUser->getValue());

            // Remplacer la valeur par la nouvelle valeur

            $value->setConsoTotal($tmpVal);

            $tmpValeur = $value;
            array_push($tmp,$tmpValeur);

        }

        return $tmp;
    }


    /**
     * La methode utilisee pour calculer la transformation totale theorique
     * @param $totalActQuart float
     * @param $consoAct float
     * @param $consoUser float
     * @return float
     */
    private function transformeTotalCalcul($totalActQuart,$consoAct,$consoUser)
    {
        $ret = ($totalActQuart* $consoUser)/$consoAct;
        return $ret;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Mesure $consoInput
     */
    public function setConsoInput($consoInput)
    {
        $this->consoInput = $consoInput;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    public function getConsoInput()
    {
        return $this->consoInput;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Mesure $consoActual
     */
    public function setConsoActual($consoActual)
    {
        $this->consoActual = $consoActual;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    public function getConsoActual()
    {
        return $this->consoActual;
    }

    /**
     * @param \Monmiel\MonmielApiBundle\Dao\DaoInterface $riakDao
     */
    public function setRiakDao($riakDao)
    {
        $this->riakDao = $riakDao;
    }
}
