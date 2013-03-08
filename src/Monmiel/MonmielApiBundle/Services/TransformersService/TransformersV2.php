<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;
use JMS\DiExtraBundle\Annotation as DI;
use \Monmiel\MonmielApiBundle\Services\TransformersService\TransformerServiceInterface;
use \Monmiel\MonmielApiModelBundle\Model\Year;
use \Monmiel\MonmielApiModelBundle\Model\Quarter;
use \Monmiel\MonmielApiModelBundle\Model\Day;

/**
 * @DI\Service("monmiel.transformers.service")
 */
class TransformersV2 implements TransformerServiceInterface
{
  /**
   * Injection of the RiakDao
   * @DI\Inject("monmiel.dao.riak")
   * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
   */
  public $riakDao;

   /**
   * default year reference
   */
    const defaultYearReferece = 2011;
  /**
   * @var
   */
  private $yearDataDefineByUser;

  private $yearReference;

  /**
  * @return Year
  */
  public function  getConsoTotalForYearReference()
    {
    /**
     * the current reference year, default 2011 or 2012
     * @var $yearReference Year
     */
    $yearReference;

    /**
     * @var $consoTotalNucleaire float
     * @var $consoTotalEolien float
     * @var $consoTotalPhotovoltaique float
     * @var $consoTotalFlamme float
     * @var $consoTotalHydraulique float
     */
    $consoTotalNucleaire; $consoTotalEolien;$consoTotalPhotovoltaique; $consoTotalFlamme; $consoTotalHydraulique;
    for($i = 1; $i<365; $i++){
        $dao = $this->getContainer()->get("monmiel.dao.riak");
        /**
         * @var $day Day
         */
        $day = $dao->getDayConso($i);
        /**
         * @var $quarter Quarter
         */
        foreach ($day->getQuarters() as $quarter) {
            $consoTotalNucleaire = $consoTotalEolien + $quarter->getNucleaire();
            $consoTotalEolien = $consoTotalEolien + $quarter->getEolien();
            $consoTotalPhotovoltaique = $consoTotalPhotovoltaique + $quarter->getPhotovoltaique();
            $consoTotalHydraulique = $consoTotalHydraulique + $quarter->getHydraulique();
            $consoTotalFlamme = $consoTotalFlamme + $quarter->getFlamme();
        }
    }
    return new Year($this->getYearReference(),$consoTotalNucleaire, $consoTotalEolien,$consoTotalPhotovoltaique, $consoTotalFlamme, $consoTotalHydraulique, null);
   }

   /**
   * @param \Monmiel\MonmielApiBundle\Dao\RiakDao $riakDao
   */
    public function setRiakDao($riakDao)
    {
        $this->riakDao = $riakDao;
    }

    public function setYearReference($yearReference)
    {
        $this->yearReference = $yearReference;
    }

    public function getYearReference()
    {
        if($this->yearReference == null)
            return TransformersV2::defaultYearReferece;
        return $this->yearReference;
    }

    /**
    * @param  $yearDataDefineByUser
    */
    public function setYearDataDefineByUser($yearDataDefineByUser)
    {
        $this->yearDataDefineByUser = $yearDataDefineByUser;
    }

    /**
     * @return
    */
    public function getYearDataDefineByUser()
    {
        return $this->yearDataDefineByUser;
    }
}
