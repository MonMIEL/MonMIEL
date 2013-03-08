<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

use JMS\DiExtraBundle\Annotation as DI;

use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersInterface;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\MonmielApiModelBundle\Model\AskUser;
use Monmiel\MonmielApiModelBundle\Model\Year;

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
    protected  $consoTotalActuel;


    /**
     * Information of each energy and megawatt hour typed by user
     * @var \Monmiel\MonmielApiModelBundle\Model\AskUser;
     */
    protected $askUser;

    /**
     * Information of each energy and megawatt hour for year ref
     * @var \Monmiel\MonmielApiModelBundle\Model\Year;
     */
    protected $year;


    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day $day
     */
    public function get($day)
    {
        $consoDay = $this->riakDao->getDayConso($day);

        return $this->UpdateConsoTotalForQuatersForDay($consoDay);
    }

    /**
     * get the Day with the Quarters updated by Day Id,actual conso and the input Conso
     * @param $dayId integer
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function updateConsoQuartersByDayIdAndConsoTotalActuelAndConsoDefineByUser($dayId, $actualConso, $inputConso)
    {
        $currentDay = $this->riakDao->getDayConso($dayId);//get the current day by id

        return $this->updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($currentDay,$actualConso,$inputConso);
    }

    /**
     * update the conso total for the Quarters of the Day in parameter with the actual conso and the Coso define by user
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($day, $actualConso, $inputConso)
    {
        $this->setConsoTotalActuel($actualConso);//define total conso actual
        $this->setConsoTotalDefinedByUser($inputConso);//define total conso define by user

        return $this->UpdateConsoTotalForQuatersForDay($day);//update conso for this day
    }

    /**
     * update sum of the list of Quarter of Day  by the current consommation and the new consommation
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    protected function UpdateConsoTotalForQuatersForDay($day)
    {
        $updatedDay = new Day($day->getDateTime());
        if (isset($day)) {
            $consoActuel = $this->getConsoTotalActuel();
            $consoTotalDefinedByUser = $this->getConsoTotalDefinedByUser();

            if(Mesure::isEqualsMesure($consoActuel,$consoTotalDefinedByUser)){
                $newQuartersArray =  $this->transformeTotalToConsoTher($day->getQuarters(), $consoActuel, $consoTotalDefinedByUser);
            }
            else{
                //convert the mesure $consoTotalDefinedByUser
                $consoInputConverted = Mesure::convertMesureByOtherUnitOfMesure($consoTotalDefinedByUser,$consoActuel->getUnitOfMesure());
                $newQuartersArray =  $this->transformeTotalToConsoTher($day->getQuarters(), $consoActuel, $consoTotalDefinedByUser);
            }
            $updatedDay->setQuarters($newQuartersArray);
        }

        return $updatedDay;
    }

    /**
     * Transformer the total of consumption given to total of consumption in theories
     * @param $listQuarter array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     * @param $consoTotalActuel \Monmiel\MonmielApiModelBundle\Model\Mesure       the actual consumption
     * @param $consoTotalDefineByUser \Monmiel\MonmielApiModelBundle\Model\Mesure      the consumption typed by user
     * @return array<\Monmiel\MonmielApiModelBundle\Model\Quarter>        array of Quarter
     */

     protected function transformeTotalToConsoTher($listQuarter, $consoTotalActuel, $consoTotalDefineByUser)
     {
       // Define a temporal list
        $quartersUpdated = array();
       // Go through the list and transformer each consumption to theoretical consumption
        foreach ($listQuarter as $quarter) {
         // Call the method for the transformation calculate
            $tmpVal= $this->transformeTotalCalcul($quarter->getConsoTotal(),$consoTotalActuel->getValue(),$consoTotalDefineByUser->getValue());
         //Replace the old value of consumption by a new one
            $quarter->setConsoTotal($tmpVal);
         //Put the value modified in the array list tmp
            array_push($quartersUpdated,$quarter);
        }

       // Return the list transformed
        return $quartersUpdated;
    }


    /**
     * This method used for the calculate of transformation, transformer actual
     * total consumption to theoretical total consumption
     * @param $totalActQuart float    the actual total consumption of this quarter
     * @param $consoTotalActValue float         the actual total consumption
     * @param $consoDefineByUserValue float        the total consumption typed by user
     * @return float                  value calculated
     */
    public  function transformeTotalCalcul($totalActQuart,$consoTotalActValue,$consoDefineByUserValue)
    {
        //Calculate
        $ret = ($totalActQuart* $consoDefineByUserValue)/$consoTotalActValue;

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
    public function setConsoTotalActuel($consoActuel)
    {
        $this->consoTotalActuel = $consoActuel;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Mesure
     */
    public function getConsoTotalActuel()
    {
        return $this->consoTotalActuel;
    }

    /**
     * @param \Monmiel\MonmielApiBundle\Dao\DaoInterface $riakDao
     */
    public function setRiakDao($riakDao)
    {
        $this->riakDao = $riakDao;
    }



    /**
     *  Get the power of each type energy for reference year
     * @return  \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPowerRef()
    {
        // return an object power calculated
        return new \Monmiel\MonmielApiModelBundle\Model\Power(
            $this->calculateWattHour2Power($this->year->getConsoTotalFlamme()),
            $this->calculateWattHour2Power($this->year->getConsoTotalHydraulique()),
            $this->calculateWattHour2Power(0),
            $this->calculateWattHour2Power($this->year->getConsoTotalNucleaire()),
            $this->calculateWattHour2Power(0),
            $this->calculateWattHour2Power($this->year->getConsoTotalPhotovoltaique()),
            $this->calculateWattHour2Power(0),
            $this->calculateWattHour2Power($this->year->getConsoTotalEolien())
        );

    }




    /**
     *  Get the power of each type energy for target year
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPowerTarget()
    {
      // return an object power calculated
      return new \Monmiel\MonmielApiModelBundle\Model\Power(
           $this->calculateWattHour2Power($this->askUser->getFlame()),
           $this->calculateWattHour2Power($this->askUser->getHydraulic()),
           $this->calculateWattHour2Power($this->askUser->getImport()),
           $this->calculateWattHour2Power($this->askUser->getNuclear()),
           $this->calculateWattHour2Power($this->askUser->getOther()),
           $this->calculateWattHour2Power($this->askUser->getPhotovoltaic()),
           $this->calculateWattHour2Power($this->askUser->getStep()),
           $this->calculateWattHour2Power($this->askUser->getWind())
           );
    }


    /**
     * This method use for the calculate from megawatt hour to Power
     * @param $wattHour float  megawatt hour
     * return float   megawatt
     */
    private function calculateWattHour2Power($wattHour){

      return $wattHour/(365*24);
    }


}
