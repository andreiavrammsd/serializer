<?php

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Collection;

class CollectionTest extends TestCase
{
    /**
     * @param array $data
     * @dataProvider collectionData
     */
    public function testCollection(array $data)
    {
        $collection = new Collection($data);

        $result = [];
        foreach ($collection as $item) {
            $result [$collection->key()] = $item;
        }

        $this->assertSame($data, $result);
        $this->assertEquals(count($data), $collection->count());
    }

    /**
     * @return array
     */
    public function collectionData() : array
    {
        return [
            [
                []
            ],
            [
                [
                    1,
                    2,
                    3,
                ]
            ],
            [
                [
                    'a',
                    'b',
                ]
            ],
        ];
    }
}
