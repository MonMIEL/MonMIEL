<?php

namespace Monmiel\MonmielApiBundle\Dao;

use Aws\DynamoDb\DynamoDbClient;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.dao.dynamo")
 */
class DynamoDbDao implements DaoInterface
{
    const TABLE_NAME = "rteIndex";
    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function gets($keys)
    {
    }

    /**
     * @param $keys array<string>
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($key)
    {
        $item = $this->client->getItem(array(
            'ConsistentRead' => true,
            'TableName' => self::TABLE_NAME,
            'Key'       => array(
                'HashKeyElement'  => array('S' => $key),
            )
        ));
        $result = $item['Item']['content']['S'];
        /** @var $day Day */
        $day = $this->serializer->deserialize($result, 'Monmiel\MonmielApiModelBundle\Model\Day', "json");

        return $day;
    }

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return mixed bool
     */
    public function put($day)
    {
        $key = $day->getKey();
        echo "put $key\n";
        $serializedDay = $this->serializer->serialize($day, "json");
        $result = $this->client->putItem(
            array(
                'TableName' => self::TABLE_NAME,
                'Item' => $this->client->formatAttributes(
                    array(
                        'id'      => $key,
                        'content' => $serializedDay
                    )
                )
            )
        );
    }

    public function createTable()
    {
        $this->client->createTable(array(
            'TableName' => 'rteIndex',
            'KeySchema' => array(
                'HashKeyElement' => array(
                    'AttributeName' => 'id',
                    'AttributeType' => 'S'
                )
            ),
            'ProvisionedThroughput' => array(
                'ReadCapacityUnits'  => 10,
                'WriteCapacityUnits' => 5
            )
        ));
        $this->client->waitUntilTableExists(array('TableName' => 'rteIndex'));
    }

    /**
     * @DI\InjectParams({
     *     "region" = @DI\Inject("%dynamo_region%")
     * })
     */
    public function __construct($region)
    {
        $this->client = DynamoDbClient::factory(
            array(
                'region' => $region
            )
        );
    }

    /**
     * @DI\Inject("debug.stopwatch")
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @DI\Inject("serializer")
     * @var \JMS\Serializer\Serializer $serializer
     */
    public $serializer;

    /**
     * @var DynamoDbClient;
     */
    public $client;

}
