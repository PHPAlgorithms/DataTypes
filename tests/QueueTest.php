<?php

namespace PHPAlgorithms\DataTypes\Tests;

use PHPAlgorithms\DataTypes\Queue;
use PHPUnit\Framework\TestCase;

/**
 * Class QueueTest
 * @package PHPAlgorithms\DataTypes\Tests
 */
final class QueueTest extends TestCase
{
    public function testCountableInterface()
    {
        $queue = new Queue;

        for ($i = 0; $i < 10; ++$i) {
            $queue->insert($i);
        }

        $this->assertEquals($queue->size(), count($queue));

        $queue->insert('z');

        $this->assertEquals($queue->size(), count($queue));
    }

    public function testInsertAfterWithCondition()
    {
        $test = str_split('abde');

        $queue = new Queue;

        foreach ($test as $letter) {
            /**
             * @var string $letter
             */

            $queue->insert($letter);
        }

        foreach (['c', 'f'] as $letter) {
            /**
             * @var string $letter
             */

            $queue->insertAfterWhen($letter, function ($value, $next) {
                return ord($value) < ord($next);
            });
        }

        $this->assertEquals('abdcef', implode($queue->toArray()));
    }

    public function testInsertBeforeWithCondition()
    {
        $test = str_split('bcdf');

        $queue = new Queue;

        foreach ($test as $letter) {
            /**
             * @var string $letter
             */

            $queue->insert($letter);
        }

        foreach (['a', 'e'] as $letter) {
            /**
             * @var string $letter
             */

            $queue->insertBeforeWhen($letter, function ($value, $next) {
                return ord($value) < ord($next);
            });
        }

        $this->assertEquals('abcdef', implode($queue->toArray()));
    }

    public function testInsertOnSpecifiedPosition()
    {
        $test = str_split('abcdef');

        $queue = new Queue;

        foreach ($test as $letter) {
            /**
             * @var string $letter
             */

            $queue->insert($letter);
        }

        $test = str_split('xyz');
        foreach ($test as $index => $letter) {
            /**
             * @var integer $index
             * @var string $letter
             */

            $position = $index * 2;
            $queue->insert($letter, $position);
            $this->assertEquals($letter, $queue->toArray()[$position]);
        }

        $this->assertEquals('xaybzcdef', implode($queue->toArray()));
    }

    public function testInsertToTheEnd()
    {
        $test = str_split('abcdefghijk');

        $queue = new Queue;

        foreach ($test as $index => $letter) {
            /**
             * @var integer $index
             * @var string $letter
             */

            if (($index % 4) === 0) {
                $queue->insertAfterEnd($letter);

                $this->assertEquals($letter, $queue->toArray()[$queue->size() - 1]);
            } else {
                $queue->insert($letter);
            }
        }

        $this->assertEquals('abcdefghijk', implode($queue->toArray()));
    }

    public function testInsertToTheHead()
    {
        $test = str_split('abcdefg');

        $queue = new Queue;

        foreach ($test as $index => $letter) {
            /**
             * @var integer $index
             * @var string $letter
             */

            if (($index % 3) === 0) {
                $queue->insertBeforeHead($letter);

                $this->assertEquals($letter, $queue->toArray()[0]);
            } else {
                $queue->insert($letter);
            }
        }

        $this->assertEquals('gdabcef', implode($queue->toArray()));
    }

    public function testJsonableInterface()
    {
        $queue = new Queue;

        for ($i = 0; $i < 10; ++$i) {
            $queue->insert($i, $i);
        }

        $this->assertEquals(json_encode($queue->toArray()), json_encode($queue));
    }

    public function testRemoveTest()
    {
        $queue = new Queue;

        for ($i = 0; $i < 10; ++$i) {
            $queue->insert($i);
        }

        $queue->remove(0);

        $this->assertEquals('123456789', implode($queue->toArray()));

        $queue->remove(5);

        $this->assertEquals('12345789', implode($queue->toArray()));

        $queue->remove(5);

        $this->assertEquals('1234589', implode($queue->toArray()));

        $this->assertEquals(7, $queue->size());
    }

    public function testSizeTest()
    {
        $queue = new Queue;

        $this->assertEquals(0, $queue->size());

        for ($i = 0; $i < 10; ++$i) {
            $queue->insert($i);
        }

        $this->assertEquals(10, $queue->size());

        $queue->insert('z', 0);

        $this->assertEquals(11, $queue->size());
    }
}
