<?php

namespace PHPAlgorithms\DataTypes\Queue;

use Closure;
use PHPAlgorithms\DataTypes\Queue;
use PHPAlgorithms\DataTypes\QueueInterface;
use PHPAlgorithms\DataTypes\Queue\PriorityQueue\ItemInterface;

/**
 * Class PriorityQueue
 * @package PHPAlgorithms\DataTypes\Queue
 */
class PriorityQueue implements QueueInterface
{
    public const TYPE_MAX = 1;

    public const TYPE_MIN = 0;

    /**
     * @var Queue $queue
     */
    private $queue;

    /**
     * @var integer
     */
    private $type;

    /**
     * PriorityQueue constructor.
     * @param integer $type
     * @throws PriorityQueue\Exception
     */
    public function __construct(int $type)
    {
        if (!in_array($type, [static::TYPE_MAX, static::TYPE_MIN], true)) {
            throw new PriorityQueue\Exception('Unknown priority queue type');
        }

        $this->type = $type;

        $this->queue = new Queue;
    }

    /**
     * @return integer
     */
    public function count() : int
    {
        return $this->size();
    }

    /**
     * @param mixed $value
     * @param float $priority
     * @return ItemInterface
     */
    private function createItem($value, float $priority) : ItemInterface
    {
        return new class($value, $priority) implements ItemInterface
        {
            /**
             * @var mixed $value
             */
            private $value;

            /**
             * @var float $priority
             */
            private $priority;

            public function __construct($value, float $priority)
            {
                $this->value = $value;

                $this->priority = $priority;
            }

            public function getPriority() : float
            {
                return $this->priority;
            }

            /**
             * @return mixed
             */
            public function getValue()
            {
                return $this->value;
            }
        };
    }

    /**
     * @return Closure
     */
    private function getWhenFunction() : Closure
    {
        if ($this->type === static::TYPE_MIN) {
            return function (ItemInterface $inserted, ItemInterface $item) : bool {
                /**
                 * @var ItemInterface $inserted
                 * @var ItemInterface $item
                 */

                return $inserted->getPriority() < $item->getPriority();
            };
        }

        return function (ItemInterface $inserted, ItemInterface $item) : bool {
            /**
             * @var ItemInterface $inserted
             * @var ItemInterface $item
             */

            return $inserted->getPriority() > $item->getPriority();
        };
    }

    /**
     * @return Queue
     */
    protected function getQueue() : Queue
    {
        return $this->queue;
    }

    /**
     * @return boolean
     */
    public function isEmpty() : bool
    {
        return $this->size() === 0;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }

    /**
     * @return mixed
     * @throws PriorityQueue\Exception
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new PriorityQueue\Exception('You can\'t pop value from an empty queue');
        }

        return $this->queue->pop()->getValue();
    }

    /**
     * @param mixed $value
     * @param float $priority
     * @return self
     */
    public function put($value, float $priority = null) : self
    {
        $priority = $priority ?? INF;

        $item = ($value instanceof ItemInterface) ? $value : $this->createItem($value, $priority);

        $this->queue->insertBeforeWhen($item, $this->getWhenFunction());

        return $this;
    }

    /**
     * @return integer
     */
    public function size() : int
    {
        return $this->queue->size();
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->queue->toArray();
    }

    /**
     * @param mixed $value
     * @param float $priority
     * @return self
     * @throws PriorityQueue\Exception
     */
    public function update($value, float $priority) : self
    {
        /**
         * @var ItemInterface $item
         * @var integer $index
         */
        list($item, $index) = $this->queue->find(function (ItemInterface $item) use ($value) {
            return $item->getValue() === $value;
        });

        if (is_null($item)) {
            throw new PriorityQueue\Exception('Sorry but item with this value is not in queue');
        }

        $this->queue->remove($index);

        return $this->put($value, $priority);
    }
}
