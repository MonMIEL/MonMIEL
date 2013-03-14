<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;
use JMS\DiExtraBundle\Annotation as DI;
use \Monmiel\MonmielApiBundle\Services\TransformersService\TransformerServiceInterface;
use \Monmiel\MonmielApiModelBundle\Model\Year;
use \Monmiel\MonmielApiModelBundle\Model\Quarter;
use \Monmiel\MonmielApiModelBundle\Model\Day;

/**
 * @DI\Service("monmiel.transformers.v2.service")
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
   * @var $yearDataDefineByUser Year
   */
  private $yearDataDefineByUser;

    /**
     * @var Year
     */
  private $yearReference;


   public function setYearReference($yearReference)
   {
        $this->yearReference = $yearReference;
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

    /**
     * get the total consummation for the different Energy for year reference, eg conso 2011
     *
     * @return Year
     */
    public function  getConsoTotalForYearReference()
    {
//       $this->getYearReference();
    }

    /**
     * calculate the median of consummation of yers in parameter
     * @param $yearTarget Year year target
     * @param $medianYearReference integer median of current year reference
     * @return float
     */
    public function calculateMedianOfConsummationForYearTarget($medianYearReference){
        if(isset($medianYearReference)){
            $consoTotalYearReference = $this->yearReference->getConsoTotalGlobale();
            $consoTotalYearTarget = $this->yearDataDefineByUser->getConsoTotalGlobale();
            if($consoTotalYearTarget != null  && $consoTotalYearReference != null){
                return $medianYearReference * $consoTotalYearTarget/$consoTotalYearReference;
            }
        }
        return null;
    }
}
