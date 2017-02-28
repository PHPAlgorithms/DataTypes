<?php

namespace PHPAlgorithms\DataTypes;

use Countable;
use JsonSerializable;

/**
 * Interface QueueInterface
 * @package PHPAlgorithms\DataTypes
 */
interface QueueInterface extends Countable, JsonSerializable
{
    /**
     * @return boolean
     */
    public function isEmpty() : bool;

    /**
     * @return mixed
     */
    public function pop();

    /**
     * @param mixed $value
     * @return self
     */
    public function put($value);

    /**
     * @return integer
     */
    public function size() : int;

    /**
     * @return array
     */
    public function toArray() : array;
}
