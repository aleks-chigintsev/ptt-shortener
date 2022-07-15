<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\query\HashUrlQuery;

/**
 * HashUrl model
 *
 * @property integer $hash_url_id
 * @property string $original_url
 * @property string $hash
 * @property string $md5_hash
 */
class HashUrl extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hash_url}}';
    }

    /**
     * {@inheritdoc}
     * @return HashUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HashUrlQuery(get_called_class());
    }
}
