<?php

namespace Monmiel\MonmielApiBundle\Dao;

use Aws\DynamoDb\DynamoDbClient;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.dao.dynamo")
 */
class DynamoDbDao implements DaoInterface
{
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
    }

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return mixed bool
     */
    public function put($day)
    {
        $key = $day->getKey();
        echo "put $key";
        $serializedDay = $this->serializer->serialize($day, "json");
        $result = $this->client->putItem(
            array(
                'TableName' => 'rteIndex',
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
     *     "key" = @DI\Inject("%dynamo_accesskey%"),
     *     "secret" = @DI\Inject("%dynamo_secretkey%"),
     *     "region" = @DI\Inject("%dynamo_region%")
     * })
     */
    public function __construct($key, $secret, $region)
    {
        $this->client = DynamoDbClient::factory(
            array(
                'key'    => $key,
                'secret' => $secret,
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
