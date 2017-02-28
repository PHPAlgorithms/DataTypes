<?php

namespace PHPAlgorithms\DataTypes;

use PHPAlgorithms\DataTypes\Queue\Exception;
use PHPAlgorithms\DataTypes\Queue\OutOfRangeException;

/**
 * Class Queue
 * @package PHPAlgorithms\DataTypes
 */
class Queue implements QueueInterface
{
    /**
     * @var array $queue
     */
    private $queue = array();

    /**
     * @var integer $size
     */
    private $size = 0;

    /**
     * @return integer
     */
    public function count()
    {
        return $this->size();
    }

    /**
     * @param callable $condition
     * @return array
     */
    public function find(callable $condition) : array
    {
        foreach ($this->queue as $index => $item) {
            /**
             * @var integer $index
             * @var mixed $item
             */

            if (call_user_func($condition, $item, $index) === true) {
                return [$item, $index];
            }
        }

        return [null, -1];
    }

    /**
     * @param mixed $value
     * @return integer
     */
    public function indexOf($value) : int
    {
        foreach ($this->queue as $index => $item) {
            /**
             * @var integer $index
             * @var mixed $item
             */

            if ($value === $item) {
                return $index;
            }
        }

        return -1;
    }

    /**
     * @param mixed $value
     * @param integer $position
     * @return self
     */
    public function insert($value, int $position = null) : self
    {
        $position = $position ?? $this->size();

        if ($position > $this->size()) {
            return $this->insertAfterEnd($value);
        } elseif ($position < 0) {
            return $this->insertBeforeHead($value);
        }

        array_splice($this->queue, $position, null, [$value]);

        ++$this->size;

        return $this;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function insertAfterEnd($value) : self
    {
        return $this->insert($value, $this->size());
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function insertAfterHead($value) : self
    {
        return $this->insert($value, 1);
    }

    /**
     * @param mixed $value
     * @param callable $when
     * @return self
     */
    public function insertAfterWhen($value, callable $when) : self
    {
        foreach ($this->queue as $index => $item) {
            /**
             * @var integer $index
             * @var mixed $item
             */

            if (call_user_func($when, $value, $item) === true) {
                return $this->insert($value, $index + 1);
            }
        }

        return $this->insertAfterEnd($value);
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function insertBeforeEnd($value) : self
    {
        return $this->insert($value, $this->size() - 1);
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function insertBeforeHead($value) : self
    {
        return $this->insert($value, 0);
    }

    /**
     * @param mixed $value
     * @param callable $when
     * @return self
     */
    public function insertBeforeWhen($value, callable $when) : self
    {
        foreach ($this->queue as $index => $item) {
            /**
             * @var integer $index
             * @var mixed $item
             */

            if (call_user_func($when, $value, $item) === true) {
                return $this->insert($value, $index);
            }
        }

        return $this->insertAfterEnd($value);
    }

    /**
     * @return boolean
     */
    public function isEmpty() : bool
    {
        return $this->size() === 0;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public function isIn($value) : bool
    {
        return $this->indexOf($value) >= 0;
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
     * @throws Exception
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new Exception('You can\'t pop value from an empty queue');
        }

        --$this->size;

        return array_shift($this->queue);
    }

    /**
     * @param mixed $value
     * @return self
     */
    public function put($value) : self
    {
        return $this->insert($value);
    }

    /**
     * @param int $position
     * @return self
     */
    public function remove(int $position) : self
    {
        if (($position < 0) || ($this->size() < $position)) {
            throw new OutOfRangeException('Sent position was out of range');
        }

        array_splice($this->queue, $position, 1, null);

        --$this->size;

        return $this;
    }

    /**
     * @return integer
     */
    public function size() : int
    {
        return $this->size;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->queue;
    }
}
