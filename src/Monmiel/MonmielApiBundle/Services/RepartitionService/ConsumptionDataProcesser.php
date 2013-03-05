<?php
/**
<!**
 * Copyright (C) 2013 M2PRO Miage Groupe Energie
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
 * USA.
 * Date: 05/03/13
 * Time: 09:05

 */

/**
 * Gets data from reference year
 * and computes estimated value for year given
 * by user, and finally production done by each
 * kind of energy
 */
class ConsumptionDataProcesser
{

    public $consumptionRetrieved = Array(); //array of values retrieved from DAO
    public $consumptionComputedTargetYear = Array();
    public $targetYearTotalConsumption; // amount of energy need for the year given in parameter
    public $referenceYearTotalConsumption; // amount of energy need for the year given in parameter

    public $repartitionGivenByEnergy; //rates for each energy given in parameter


    /**Makes an extrapolation of reference's year
     * using the same repartition
     * @return array
     */
    private function  computesConsumptionForTargetYear()

    {
        $coeffToUse = $this->computesRatesByEnergy();

        for ($i = 0; $i < sizeof($this->consumptionRetrieved); $i++) {
            //i retrieve a day
            $currentDay = $this->consumptionRetrieved[$i];

            $current = $currentDay;
            $current->setQuarters(array());
            $currentDayQuarters = $currentDay->getgetQuarters();

            for ($j = 0; $j < sizeof($currentDayQuarters); $j++) {

                $currentQuarter = $currentDayQuarters[$j];
                $currentQuarter = $this->updateQuarter($currentQuarter, $coeffToUse);
                array_push($current, $currentQuarter);
            }


            array_push($consumptionComputedTargetYear, $current);

        }


    }

    /**
     *Computes rates between year reference and target year
     *
     */
    public function computesRatesByEnergy()
    {
        $coeff = $this->targetYearTotalConsumption / $this->referenceYearTotalConsumption;

        return $coeff;
    }


    private function updateQuarter($quarter, $coeff)

    {
        $updatedValue = $quarter->coeffMuliplication($coeff);


        return $updatedValue;

    }

}
