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
        $hash = md5($this->_hashBase);
        // replace digital
        $hash = preg_replace_callback('/[0-9]/s', function($matches) {
            return self::$_availableChars[rand(0, 51)];
        }, $hash);
        $hash = substr($hash, 0, $this->_hashSize);
        // uppercase every odd-number symbol
        $hash = preg_replace_callback('/(\w)(.?)/', function($matches) {
            return $matches[1] . strtoupper($matches[2]);
        }, $hash);
        return $hash;
    }
}