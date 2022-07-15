<?php

namespace common\models\query;

use Yii;
use common\models\RedirectRecord;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[RedirectRecord]].
 *
 * @see RedirectRecord
 */
class RedirectRecordQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return RedirectRecord[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RedirectRecord|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
