<?php

namespace backend\components\HashGeneratorStrategy;

class BaseHashGeneratorStrategy
{
    /**
     * @var string $_availableChars
     */
    protected static $_availableChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    /**
     * @var int $_hashSize
     */
    protected $_hashSize;

    /**
     * @var int $_hashBase;
     */
    protected $_hashBase;

    /**
     * @param int size
     * @param int base
     * {@inheritDoc}
     */
    public function __construct(int $size, int $base)
    {
        $this->_hashSize = $size;
        $this->_hashBase = $base;
    }

    /**
     * @return int $size
     */
    public function getSize(): int
    {
        return $this->_hashSize;
    }
}