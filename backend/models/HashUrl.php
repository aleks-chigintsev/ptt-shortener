<?php

namespace backend\models;

use Yii;

/**
 * Backend HashUrl model for use in forms
 */
class HashUrl extends \common\models\HashUrl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['original_url', 'hash', 'md5_hash'], 'safe'],
            ['hash', 'unique'],
        ];
    }
}
