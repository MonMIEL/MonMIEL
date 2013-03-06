<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

use JMS\DiExtraBundle\Annotation as DI;

use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersInterface;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Mesure;

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
    protected  $consoTotalDefinedByUser;

    /**
     * the actual consommation
     * @var \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    protected  $consoActuel;


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
    public function updateConsoTotalForDayWithActualConsoAndInputConso($day, $actualConso, $inputConso)
    {
        $this->setConsoActuel($actualConso);
        $this->setConsoTotalDefinedByUser($inputConso);

        return $this->getTotalUpdated($day);
    }


    /**
     * get the Day with the Quarters updated by Day Id,actual conso and the input Conso
     * @param $dayId integer
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function getDayUpdatedByDayIdActualConsoAndInputConso($dayId, $actualConso, $inputConso)
    {
        $this->setConsoActuel($actualConso);
        $this->setConsoTotalDefinedByUser($inputConso);
        $dayTemp = $this->riakDao->getDayConso($dayId);
        return $this->getTotalUpdated($dayTemp);
    }

    /**
     * update sum of the list of Quarter of Day  by the current consommation and the new consommation
     * @param $consoDay \Monmiel\MonmielApiModelBundle\Model\Day
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    protected function getTotalUpdated($consoDay)
    {
        $updatedDay = new Day($consoDay->getDateTime());
        if (isset($consoDay)) {
            $consoActuel = $this->getConsoActuel();
            $consoTotalDefinedByUser = $this->getConsoTotalDefinedByUser();
            $newQuartersArray =  $this->transformeTotalToConsoTher($consoDay->getQuarters(), $consoActuel, $consoTotalDefinedByUser);
            $updatedDay->setQuarters($newQuartersArray);

//            if(Mesure::isEqualsMesure($consoActuel,$consoTotalDefinedByUser)){
//                $array =  $this->transformeTotalToConsoTher($consoDay->getQuarters(),$consoActuel,$consoTotalDefinedByUser);
//                $retour->setQuarters($array);
//            }
//            else{
//                $consoInputConverted = Mesure::convertMesureByOtherUnitOfMesure($consoTotalDefinedByUser,$consoActuel->getUnitOfMesure());
//                $array =  $this->transformeTotalToConsoTher($consoDay->getQuarters(),$this->getConsoActuel(), $consoInputConverted);
//                $retour->setQuarters($array);
//                echo "------ different mesure \n -------";
//            }
        }

        return $updatedDay;
    }

    /**
     * Transformer the total of consumption given to total of consumption in theories
     * @param $listQuarter array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     * @param $consoAct \Monmiel\MonmielApiModelBundle\Model\Mesure       the actual consumption
     * @param $consoUser \Monmiel\MonmielApiModelBundle\Model\Mesure      the consumption typed by user
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>        array of Quarter
     */

     protected function transformeTotalToConsoTher($listQuarter, $consoAct, $consoUser)
     {
       // Define a temporal list
        $tmp = array();
       // Go through the list and transformer each consumption to theoretical consumption
        foreach ($listQuarter as $quarter) {
         // Call the method for the transformation calculate

            $tmpVal= $this->transformeTotalCalcul($quarter->getConsoTotal(),$consoAct->getValue(),$consoUser->getValue());
         //Replace the old value of consumption by a new one
            $quarter->setConsoTotal($tmpVal);
         $tmpValeur = $value;
         //Put the value modified in the array list tmp
            array_push($tmp,$tmpValeur);
        }
       // Return the list transformed
        return $tmp;
    }


    /**
     * This method used for the calculate of transformation, transformer actual
     * total consumption to theoretical total consumption
     * @param $totalActQuart float    the actual total consumption of this quarter
     * @param $consoAct float         the actual total consumption
     * @param $consoUser float        the total consumption typed by user
     * @return float                  value calculated
     */
    public function transformeTotalCalcul($totalActQuart,$consoAct,$consoUser)
    {
      // Calculate
        $ret = ($totalActQuart* $consoUser)/$consoAct;
        return $ret;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Mesure $consoTotalDefinedByUser
     */
    public function setConsoTotalDefinedByUser($consoTotalDefinedByUser)
    {
        $this->consoTotalDefinedByUser = $consoTotalDefinedByUser;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    public function getConsoTotalDefinedByUser()
    {
        return $this->consoTotalDefinedByUser;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Mesure $consoActuel
     */
    public function setConsoActuel($consoActuel)
    {
        $this->consoActuel = $consoActuel;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    public function getConsoActuel()
    {
        return $this->consoActuel;
    }

    /**
     * @param \Monmiel\MonmielApiBundle\Dao\DaoInterface $riakDao
     */
    public function setRiakDao($riakDao)
    {
        $this->riakDao = $riakDao;
    }
}
