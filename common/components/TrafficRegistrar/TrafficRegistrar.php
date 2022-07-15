<?php

namespace common\components\TrafficRegistrar;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use backend\helpers\UtilHelper;
use backend\models\RedirectRecord;
use backend\models\HashUrl;

/**
 * Сomponent for register traffic
 */
class TrafficRegistrar extends Component
{
    /**
     * @var int $_hashUrlId
     */
    private $_hashUrlId;

    /**
     * @var string $_userAgent
     */
    private $_userAgent;

    /**
     * @param int $hashUrlId
     * @param string $userAgent
     * {@inheritDoc}
     */
    public function __construct(
        int $hashUrlId, 
        string $userAgent, 
        $config = []
    )
    {
        if (!HashUrl::find()->where(['hash_url_id' => $hashUrlId])->exists()) {
            throw new InvalidConfigException("Param hashUrlId is not valid ID, 
                not found HashUrl by [{$hashUrlId}]");
        }
        $this->_hashUrlId = $hashUrlId;
        $this->_userAgent = $userAgent;
        parent::__construct($config);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        if (!$this->isBotUserAgent()) {
            $this->createRecord();
        }
    }

    /**
     * @return bool
     */
    public function isBotUserAgent(): bool
    {
        return UtilHelper::isBotUserAgent($this->_userAgent);
    }

    /**
     * @return void
     */
    private function createRecord()
    {
        $model = new RedirectRecord();
        $model->load([
            'hash_url_id' => $this->_hashUrlId,
            // TODO!: to TimetampBehaviour
            'dt_register' => time(),
            'ua' => $this->_userAgent,
        ], '');
        $model->save();
    }
}
