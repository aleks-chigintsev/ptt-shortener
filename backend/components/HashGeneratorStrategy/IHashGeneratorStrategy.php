<?php 

namespace backend\components\HashGeneratorStrategy;

/**
 * @property int $_hashBase (milliseconds | id from database)
 * @property int $_hashSize
 */
interface IHashGeneratorStrategy
{
    /**
     * Generate method
     * @return string $hash
     */
    public function generate(): string;
}