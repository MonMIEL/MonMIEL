<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

            $handle = fopen($input->getArgument("csv"), "r");
        $row = 1;
        while ($line = fgetcsv($handle)) {
            if($row == 1){ $row++; continue; }
            var_dump($line);
        }

        //Heure; fioul pointe; charbon; gaz; nucléaire; eolien; hydrolique; autre; solde; mois; jours; heure; minute; pv;
    }
}
