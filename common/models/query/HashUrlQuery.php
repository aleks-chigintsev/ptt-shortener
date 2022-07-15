<?php

namespace common\models\query;

use Yii;
use common\models\HashUrl;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[HashUrl]].
 *
 * @see HashUrl
 */
class HashUrlQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return HashUrl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HashUrl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
