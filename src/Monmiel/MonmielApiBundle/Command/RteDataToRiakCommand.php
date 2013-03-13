<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Symfony\Component\Yaml\Parser;


class RteDataToRiakCommand extends ContainerAwareCommand
{


    /**
     * L'année des données Rte (2011 ou 2012)
     * @var integer $year
     */
    protected $year;

    /**
     * @var null
     */
    protected $yamlFileConf = NULL;

    /**
     * @DI\Inject(monmiel.dao.riak)
     * @var \Monmiel\MonmielApiBundle\Dao\RiakDao
     */
    protected $dao;

    /**
     * @var \JMS\Serializer\Serializer $serializer
     */
    protected $serializer;

    protected function configure()
    {
        $this
            ->setName("monmiel:populate")
            ->setDescription("Extract Data from RTE and populate Riak")
            ->addArgument(
            "csv",
            InputArgument::REQUIRED,
            "File path of RTE data with CSV Format"
            )
            ->addArgument(
            "info",
            InputArgument::REQUIRED,
            "Path of file infos "
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->serializer = $this->getContainer()->get("serializer");
        $this->dao = $this->getContainer()->get("monmiel.dao.riak");

        //get and open the csv file
        $handle = fopen($input->getArgument("csv"), "r");
        //get and parse the info file
        $fileInfo = $input->getArgument("info");
        $yaml = new Parser();
        $this->yamlFileConf = $yaml->parse(file_get_contents((string)$fileInfo));
        $this->year = $this->yamlFileConf["YEARSTART"];
        //parse csv file and extract each step
        $dateTime = NULL;
        $dateTimeLast = NULL;
        $firstLine = true;
        $pattern  = "/[0-9][0-9]:[0-9][0-9]/";
        $hour = NULL;
        $match = NULL;
        $day = NULL;
        $quarter=NULL;

        //extract 2 line for approximate an interval for the first line
        while ($line = fgetcsv($handle)) {
            $lineExtract = explode($this->yamlFileConf["SEPARATOR"], $line[0]);
            //test if the current hour match with hour pattern
            $match = preg_match_all( $pattern,$lineExtract[$this->yamlFileConf["HOUR"]],$hour);
            if ($match>0){
                //extract date of the first line
                $dateTimeLast = date_create_from_format('Y-m-d H:i',$this->yamlFileConf["YEARSTART"]."-".$this->yamlFileConf["MONTHSTART"]."-".$this->yamlFileConf["DAYSTART"]." ".$hour[0][0] );
                $line = fgetcsv($handle);
                $lineExtract = explode($this->yamlFileConf["SEPARATOR"], $line[0]);
                //test if the current hour match with hour pattern
                $match = preg_match_all( $pattern,$lineExtract[$this->yamlFileConf["HOUR"]],$hour);
                if ($match>0){
                    //extract date of the second line
                    $dateTime = date_create_from_format('Y-m-d H:i',$dateTimeLast->format('Y-m-d')." ".$hour[0][0] );
                    break;
                }
            }
        }
        // test if previews approximation done correctly
        if ($dateTimeLast!=NULL and $dateTime!=NULL){
            //calculate interval in minutes between first and second line
            $interval = $dateTimeLast->diff($dateTime);
            //specific case: more than one day between first and second line
            if ($interval->format('%R') == '-'){
                //add one day to the second date
                $dateTime->modify($interval->format('+1 day'));
                //generate new date with correct hour
                $dateTime = date_create_from_format('Y-m-d H:i',$dateTime->format("Y-m-d")." ".$hour[0][0] );
                $interval = $dateTime->diff($dateTimeLast);
            }
            //convert DateInterval to minutes
            $intervalInt= ($interval->i) + ($interval->h * 60) + ($interval->d * 60 * 24);

            //clear buffer of csv file
            fclose($handle);
            $handle = fopen($input->getArgument("csv"), "r");

            //for each line of csv file
            while ($line = fgetcsv($handle)) {
                //extract hour of the current step
                $lineExtract = explode($this->yamlFileConf["SEPARATOR"], $line[0]);
                //test if the current hour match with hour pattern
                $match = preg_match_all( $pattern,$lineExtract[$this->yamlFileConf["HOUR"]],$hour);
                if ($match>0){
                    if($firstLine){
                        //create date with info file parameter
                        $dateTimeLast = date_create_from_format('Y-m-d H:i',$this->yamlFileConf["YEARSTART"]."-".$this->yamlFileConf["MONTHSTART"]."-".$this->yamlFileConf["DAYSTART"]." ".$hour[0][0] );
                        //create a Day object
                        $day = new Day($dateTimeLast);
                        //call extractStep for generate the current step into Quarter format
                        $quarter = $this->extractStep($lineExtract,$dateTimeLast,$intervalInt);
                        //add Quarter to Day
                        $day->addQuarters($quarter);
                        $firstLine = false;
                    }else{
                        //create date of current step
                        $dateTime = date_create_from_format('Y-m-d H:i',$day->getDateTime()->format('Y-m-d')." ".$hour[0][0] );
                        //calculate interval between current date and date of the last step
                        $interval = $dateTimeLast->diff($dateTime);
                        // if $interval is negative, change day to next day
                        if ($interval->format('%R') == '-'){
                            $this->dao->put($day);
                            //add one day to the date of last step
                            $dateTime->modify($interval->format('+1 day'));
                            //generate new date with correct hour
                            $dateTime = date_create_from_format('Y-m-d H:i',$dateTime->format("Y-m-d")." ".$hour[0][0] );
                            $interval = $dateTime->diff($dateTimeLast);
                            $intervalInt= ($interval->i) + ($interval->h * 60) + ($interval->d * 60 * 24);
                            //create new day
                            $day = new Day(date_create_from_format('Y-m-d H:i',$dateTime->format("Y-m-d")." "."00:00"));
                            //call extractStep for generate the current step into Quarter format
                            $quarter = $this->extractStep($lineExtract,$dateTime,$intervalInt);
                        }else{
                            $intervalInt= ($interval->i) + ($interval->h * 60) + ($interval->d * 60 * 24);
                            //add minutes to the day date
                            $dateTime = $dateTimeLast->modify($interval->format('+%I minutes'));
                            //extractStep for generate the current step into Quarter format
                            $quarter = $this->extractStep($lineExtract,$dateTimeLast,$intervalInt);
                        }
                        //add quarter to day
                        $day->addQuarters($quarter);
                        $dateTimeLast = $dateTime;
                    }
                }
            }
            //last days is never pushed into dao, following line do this
            if ($day!=NULL){$this->dao->put($day);}
        }
    }

    /**
     * @param $lineExtract
     * @param $dateTime
     * @param $intervalInt
     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    protected function extractStep($lineExtract,$dateTime,$intervalInt)
     {
         // extract values of line with info parameters
         $flame = $lineExtract[$this->yamlFileConf["FIOUL"]]+$lineExtract[$this->yamlFileConf["GAZ"]]+$lineExtract[$this->yamlFileConf["CHARBON"]];
         $nucleaire = $lineExtract[$this->yamlFileConf["NUCLEAIRE"]];
         $eolien = $lineExtract[$this->yamlFileConf["EOLIEN"]];
         $hydraulique = $lineExtract[$this->yamlFileConf["HYDROLIQUE"]];
         $photovoltaique = (integer) $lineExtract[$this->yamlFileConf["PV"]];
         $autre = (integer) $lineExtract[$this->yamlFileConf["AUTRES"]];
         $consoTotal = $flame + $nucleaire + $eolien + $hydraulique + $photovoltaique + $autre;
         //new Quarter
         $quarter = new Quarter(clone ($dateTime), $consoTotal, $eolien, $flame, $hydraulique, $nucleaire, $photovoltaique, $autre,$intervalInt );
         return $quarter;
     }
}
