<?php

namespace Tests;

use App\JsonParser;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_getNamedNodes_returns_an_array()
    {
        $result = (new JsonParser)->getNamedNodes();
        $this->assertIsArray($result);
    }

    public function test_getNamedNodes_returns_all_nodes_with_a_name_and_their_frequency()
    {
        $expected = [
            "type" => "DateTime",
            "name" => "start_time",
            "label" => "Start Time",
            "clampedTimeReference" => null,
            "isRequired" => true,
            "value" => "2019-02-12T18:00:00+00:00",
            "uuid" => "f958e764-b0db-4370-8945-8f1a2c2fee49",
       ];

        $results = (new JsonParser)->getNamedNodes();

        $this->assertEquals(87, $results['count']);
        $this->assertIsArray($results['results']);
        $this->assertEquals($expected, $results['results'][0]);
    }

    public function test_getNodeValues_returns_an_array()
    {
        $result = (new JsonParser)->getNodeValues('header');
        $this->assertIsArray($result);
    }

    public function test_getNodeValues_returns_a_single_leaf_node()
    {
        // only expecting one node here since its the only node with the name of "start_time"
        // without any children, making it a leaf node.
        $expected = [
            [
                "type" => "DateTime",
                "name" => "start_time",
                "label" => "Start Time",
                "clampedTimeReference" => null,
                "isRequired" => true,
                "value" => "2019-02-12T18:00:00+00:00",
                "uuid" => "f958e764-b0db-4370-8945-8f1a2c2fee49",
            ]
        ];

        $result = (new JsonParser)->getNodeValues('start_time');
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    public function test_getNodeValues_return_no_nodes_as_they_are_not_leaf_nodes()
    {
        // even though we have a lot of nodes with a labour type, non of them
        // are actually leaf nodes since they contain an extra metadata node
        $result = (new JsonParser)->getNodeValues('labour_type');

        $this->assertIsArray($result);
        $this->assertEquals([], $result);
    }
}
