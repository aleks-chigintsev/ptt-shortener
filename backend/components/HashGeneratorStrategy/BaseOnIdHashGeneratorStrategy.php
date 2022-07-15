<?php

namespace backend\components\HashGeneratorStrategy;

class BaseOnMillisecondHashGeneratorStrategy 
    extends BaseHashGeneratorStrategy
    implements IHashGeneratorStrategy
{
    /**
     * {@inheritDoc}
     */
    public function generate(): string
    {
        // TODO: on base ID from backend\model\HashUrl::$hash_url_id
        $hash = "";
        for ($i = 0; $i <= $this->_hashSize; $i++) {
            $hash .= self::$_availableChars[rand(0, 51)];
        }
        return $hash;
    }
}