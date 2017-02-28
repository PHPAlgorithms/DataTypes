<?php

namespace PHPAlgorithms\DataTypes\Queue\PriorityQueue;

/**
 * Interface ItemInterface
 * @package PHPAlgorithms\DataTypes\Queue\PriorityQueue
 */
interface ItemInterface
{
    /**
     * ItemInterface constructor.
     * @param mixed $value
     * @param float $priority
     */
    public function __construct($value, float $priority);

    /**
     * @return float
     */
    public function getPriority() : float;

    /**
     * @return mixed
     */
    public function getValue();
}
