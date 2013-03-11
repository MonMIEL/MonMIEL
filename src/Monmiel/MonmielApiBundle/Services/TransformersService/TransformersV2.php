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
   * default year reference
   */
    const defaultYearReferece = 2011;
  /**
   * @var
   */
  private $yearDataDefineByUser;

  private $yearReference;


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

    /**
     * get the total consummation for the different Energy for year reference, eg conso 2011
     *
     * @return Year
     */
    public function  getConsoTotalForYearReference()
    {
        // TODO: Implement getConsoTotalForYearReference() method.
    }}
