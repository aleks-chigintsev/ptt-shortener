<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\query\RedirectRecordQuery;

/**
 * RedirectRecord model
 *
 * @property integer $redirect_record_id
 * @property integer $hash_url_id
 * @property integer $dt_register
 * @property string $ua
 */
class RedirectRecord extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%redirect_record}}';
    }

    /**
     * {@inheritdoc}
     * @return RedirectRecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RedirectRecordQuery(get_called_class());
    }
}
