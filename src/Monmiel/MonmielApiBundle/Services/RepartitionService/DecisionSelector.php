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
 * Date: 11/03/13
 * Time: 11:01
 */
namespace Monmiel\MonmielApiBundle\Services\RepartitionService;
use Symfony\Component\Yaml\Parser;
use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;

/**
 * @DI\Service("monmiel.repartition.decision.service")
 */
class DecisionSelector
{
    /***
     * @base des calculs
     */
    private static $median_value = 5474; //median value of consumption for this year
    protected static $max_import = 40000; //MW
    protected static $max_export = 12000000000; //MW
    protected static $max_storable_in_steps = 5000; //MW
    private static $peak_coeff = 1.25; //
    protected static $stored_in_steps = 0;
    protected static $energy_step_max = 90000; //GWH
    protected static $energy_import_max = 45000000; //GWH a definir
    protected static $energy_step_used = 0; //GWH
    protected static $energy_import_used = 0; //GWH
    protected static $power_losed = 0;
    protected static $power_exported = 0;
    protected static $import_base_cost = 67;
    protected static $import_peak_min_cost = 80;
    protected static $import_peak_max_cost = 367;
    protected static $thermal_cost = 100;
    protected $storingCoeff = 1.15;
    protected static $imported = 0;
    private $filename = '/app/Resources/rte/monmiel-prices.yml';

    /**
     * Set maximal values for steps and imports
     * @param int $coeffOfMixYear based on totalMixYearConsumption /refYear
     */
    public function set($coeffOfMixYear = 1)
    {
        DecisionSelector:: $max_import = 8000 * $coeffOfMixYear;
        DecisionSelector::  $max_storable_in_steps = 5000 * $coeffOfMixYear;
        DecisionSelector::  $energy_step_max = 90000 * $coeffOfMixYear; //GWH
        DecisionSelector:: $energy_import_max = 45000000 * $coeffOfMixYear;
    }

    /**
     * @param $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
     * @return string
     */
    public function storeInStepsOrExport($quarter)
    {
        $produced = $quarter->getHydraulique() + $quarter->getEolien() + $quarter->getPhotovoltaique() + $quarter->getNucleaire();
        $plusValue = $produced - $quarter->getConsoTotal();
        $valueToStore = $plusValue / $this->storingCoeff;
        if ($plusValue > 0) {
            //echo "\n ENERGIE STOCKABLE \n";
            $valueToExport = $plusValue - (DecisionSelector::$max_storable_in_steps - DecisionSelector::$stored_in_steps);
            DecisionSelector::$stored_in_steps = min(DecisionSelector::$stored_in_steps + $valueToStore, DecisionSelector::$max_storable_in_steps - DecisionSelector::$stored_in_steps);
            if ($valueToExport < 0)
                return;
            DecisionSelector::$power_exported = min($valueToExport, DecisionSelector::$max_export - DecisionSelector::$power_exported);
            //echo "\n EXPORT \n";
        }
    }

    public function getDecisionAndUpdatesQuarterDeficit($quarterToCompute, $soldeToDistribute)
    {
        /**
         * @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarter
         */
        $quarter = clone $quarterToCompute;
        /**
         * @var DateTime $date
         */
        $date = $quarter->getDate();
        if ($soldeToDistribute < DecisionSelector::$stored_in_steps && !$this->maxStepEnegyReached($quarter, $soldeToDistribute)) {
            DecisionSelector::$energy_step_used = $soldeToDistribute / (60 / $quarter->getInterval()) + DecisionSelector::$energy_step_used;
            //echo "\n UTILISATION DES STEPPES \n";
            //checking for steps
            //maj steps
            DecisionSelector::$stored_in_steps = DecisionSelector::$stored_in_steps - $soldeToDistribute;
            $quarter->setSteps($soldeToDistribute);
            $quarter->setFlamme(0);
            return $quarter;
        } else {
            $soldeToDistribute = $soldeToDistribute - DecisionSelector::$stored_in_steps;
            DecisionSelector::$stored_in_steps = 0; //emptying steps
            return $this->chooseBetweenThermalOrImport($quarter, $soldeToDistribute);
        }
    }

    /**
     * @param $quarter Quarter
     * @return mixed
     */
    public function isAPeak($quarter)
    {
        $result = $quarter->getConsoTotal() > DecisionSelector::$median_value;
        return $result;
    }

    /**
     * @param $quarter Quarter
     * @param $solde
     */
    private function chooseBetweenThermalOrImport($quarter, $solde)
    {
        $currentCost = $this->computeImportPeakCost();
        if (($this->isAPeak($quarter) && DecisionSelector::$thermal_cost < $currentCost) || $this->maxImportEnegyReached($quarter, $solde)) {
            $quarter->setFlamme($solde);
            //echo "\n FLAMME SEULEMENT \n";
        } else {
            //echo "\n FLAMME ET IMPORT \n";
            if (!$this->isAPeak($quarter))
                $currentCost = DecisionSelector::$import_base_cost;
            $quarter->setImport(min($solde, DecisionSelector::$max_import - DecisionSelector::$imported));
            $solde = max($solde, DecisionSelector::$max_import - DecisionSelector::$imported);
            $import_value = min($solde, DecisionSelector::$max_import - DecisionSelector::$imported);
            DecisionSelector::$energy_import_used = DecisionSelector::$energy_import_used + $solde / (60 / $quarter->getInterval());
            DecisionSelector::$imported = $import_value;
            $solde = $solde - $import_value;
            $quarter->setFlamme($solde);
            $this->updatesTarification($import_value, $solde, $currentCost);
        }
        return $quarter;
    }

    /**
     * @param $quarter Quarter
     * @param $soldeToDistribute
     * @return bool
     */
    private function  maxStepEnegyReached($quarter, $soldeToDistribute)
    {
        $energy_step_used = $soldeToDistribute / (60 / $quarter->getInterval()) + DecisionSelector::$energy_step_used;
        // echo "maximum reached \n";
        return $energy_step_used >= DecisionSelector::$energy_step_max;
    }

    private function  maxImportEnegyReached($quarter, $soldeToDistribute)
    {

        $energy_import_used = $soldeToDistribute/(60 /$quarter->getInterval()) + DecisionSelector::$energy_import_used;
        $result = $energy_import_used >= DecisionSelector::$energy_import_max;
      
        return $result;
    }

    private function updatesTarification($imported, $thermal, $importCost)
    {
//TODO CARLY RAE JEPSEN
    }

    /**
     * @param $date \Symfony\Component\Validator\Constraints\DateTime
     * @param $solde float
     */
    private function computeImportPeakCost()
    {
        $result = rand(DecisionSelector::$import_peak_min_cost, DecisionSelector::$import_peak_max_cost); //->import_peak_min_cost,$this->import_peak_max_cost);
        return $result;
    }
}
