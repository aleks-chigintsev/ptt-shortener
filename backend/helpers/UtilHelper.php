<?php

namespace backend\helpers;

use Yii;

class UtilHelper
{
    /**
     * Generate Yii Bash command
     * @param string $command command for only **php yii**, ex:
     * ``` redirect/async-handler ```
     * @param array $params array **no-name** params for command
     * @return string $fullCommand
     */
    public static function getConsoleBashCommand(string $command, array $params)
    {
        $params = array_map(function($el) {
            return is_numeric($el) 
                ? $el 
                : '"' . str_replace('"', '\"', $el) . '"';
        }, $params);
        return "cd " . Yii::getAlias('@root') . " && php yii " . $command . " " . 
            implode(" ", $params) . " &";
    }

    /**
     * Check user-agent on the signs of a bot
     * @param string $ua
     * @return bool $checkResult
     */
    public static function isBotUserAgent(string $ua): bool
    {
        // TODO! super fast version from:
        // https://stackoverflow.com/a/1717091/14700812
        // can be modified if desired :)
        return preg_match('/(.*){0,}(bot|spider)(.*){0,}/i', $ua)
            ? true
            : false;
    }
}