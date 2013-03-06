<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Day;

class RteDataToRiakCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:populate")
            ->setDescription("Extract Data from RTE and populate Riak")
            ->addArgument(
            "csv",
            InputArgument::REQUIRED,
            "File path of RTE data with CSV Format"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->serializer = $this->getContainer()->get("serializer");
        $this->dao = $this->getContainer()->get("monmiel.dao.riak");

        $handle = fopen($input->getArgument("csv"), "r");
        $row = 1;
        $dateTime = \DateTime::createFromFormat('j-M-Y H:i:s', '01-Jan-2011 00:00:00');
        $day = new Day($dateTime);
        while ($line = fgetcsv($handle)) {
            if($row == 1){ $row++; continue; }
            $q = $this->extractQuarterFromLine($line[0]);
            $day->addQuarters($q);
            if ((($row-1) % 96) == 0) {
                $this->dao->put($day);
               $day = new Day($dateTime->modify('+1 day'));
//               $json = $this->serializer->serialize($day, "json");
//               var_dump($json);
            }
            $row ++;
        }
    }

    /**
     * @param $line string
     */
    protected function extractQuarterFromLine($line)
    {
        $line = explode(";", $line);
        $format = 'Y-m-d H:i';
        $date = date_create_from_format($format, "2011-$line[9]-$line[10]"." ".$line[0]);
        $flame = $line[1]+$line[2]+$line[3];
        $nucleaire = $line[4];
        $eolien = $line[5];
        $hydraulique = $line[6];
        $autre = (integer) $line[7];
        $solde = $line[8];
        $photovoltaique = (integer) $line[13];
        $consoTotal = $line[14];

        $quarter = new Quarter($date, $consoTotal, $eolien, $flame, $hydraulique, $nucleaire, $photovoltaique, $autre, $solde);

        return $quarter;
    }

    /**
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    protected $dao;

    /**
     * @var \JMS\Serializer\Serializer $serializer
     */
    protected $serializer;
}
