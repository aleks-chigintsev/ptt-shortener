<?php

namespace backend\models;

use Yii;

/**
 * Backend RedirectRecord model for use in forms
 */
class RedirectRecord extends \common\models\RedirectRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash_url_id', 'dt_register', 'ua'], 'safe'],
        ];
    }
}
