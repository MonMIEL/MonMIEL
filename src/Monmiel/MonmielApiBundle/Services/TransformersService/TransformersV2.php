<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;
use JMS\DiExtraBundle\Annotation as DI;
use \Monmiel\MonmielApiBundle\Services\TransformersService\TransformerServiceInterface;

/**
 * @DI\Service("monmiel.transformers.service")
 */
  class TransformersV2 implements TransformerServiceInterface
    {
        /**
         * @return Year
         */
        public function  getConsoTotalForYearReference()
        {
            // TODO: Implement getConsoTotalForYearReference() method.
        }

        /**
         * @return Year
         */
        public function getConsoTotalForYearTarget()
        {
            // TODO: Implement getConsoTotalForYearTarget() method.
        }
    }
