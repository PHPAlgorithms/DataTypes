<?php

namespace PHPAlgorithms\DataTypes\Tests;

use PHPAlgorithms\DataTypes\Queue\PriorityQueue;
use PHPUnit\Framework\TestCase;

/**
 * Class PriorityQueueTest
 * @package PHPAlgorithms\DataTypes\Tests
 */
final class PriorityQueueTest extends TestCase
{
    public function testPutNewObjectsWithTypeMax()
    {
        $queue = new PriorityQueue(PriorityQueue::TYPE_MAX);

        for ($i = 0; $i < 10; ++$i) {
            $queue->put($i, $i);
        }

        $i = 9;
        while (!$queue->isEmpty()) {
            $this->assertEquals($i, $queue->pop());

            --$i;
        }
    }

    public function testPutNewObjectsWithTypeMin()
    {
        $queue = new PriorityQueue(PriorityQueue::TYPE_MIN);

        for ($i = 0; $i < 10; ++$i) {
            $queue->put($i, $i);
        }

        $i = 0;
        while (!$queue->isEmpty()) {
            $this->assertEquals($i, $queue->pop());

            ++$i;
        }
    }

    public function testUpdateItemPriority()
    {
        $queue = new PriorityQueue(PriorityQueue::TYPE_MIN);

        for ($i = 0; $i < 10; ++$i) {
            $queue->put($i, $i);
        }

        $queue->update(4, 0);
        $queue->update(8, 0);
        $queue->update(9, 0);

        $i = 0;
        $values = array(0, 4, 8, 9, 1, 2, 3, 5, 6, 7);
        while (!$queue->isEmpty()) {
            $this->assertEquals($values[$i], $queue->pop());

            ++$i;
        }
    }
}
