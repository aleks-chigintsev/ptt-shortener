<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\validators\UrlValidator;
use backend\models\HashUrl;
use backend\components\HashGeneratorStrategy\IHashGeneratorStrategy;
use yii\base\InvalidConfigException;

/**
 * Сomponent for providing a short link
 */
class ShortenerUrlProvider extends Component
{
    /**
     * @var string $_originalUrl required URL-format string
     */
    private $_originalUrl;

    /**
     * @var string|null $_lastHash last requested hash
     */
    private $_lastHash;

    /**
     * Use BaseOnMillisecondHashGeneratorStrategy or BaseOnIdHashGeneratorStrategy
     * default: BaseOnMillisecondHashGeneratorStrategy from DI-configuration
     * @var IHashGeneratorStrategy $_generatorStrategy
     */
    private $_generatorStrategy;

    /**
     * @param IHashGeneratorStrategy $strategy
     * @return void
     */
    public function setGeneratorStrategy(IHashGeneratorStrategy $strategy)
    {
        $this->_generatorStrategy = $strategy;
    }

    /**
     * @param string $originalUrl
     * @param IHashGeneratorStrategy $strategy
     * {@inheritDoc}
     */
    public function __construct(
        string $originalUrl, 
        IHashGeneratorStrategy $strategy, 
        $config = []
    )
    {
        $validator = new UrlValidator();
        if (!$validator->validate($originalUrl, $error)) {
            throw new InvalidConfigException('Param originalUrl is not valid URL');
        }
        $this->_originalUrl = $originalUrl;
        $this->_generatorStrategy = $strategy;
        parent::__construct($config);
    }

    /**
     * @return string get hash
     */
    public function getHash(): string
    {
        if ($this->_lastHash === null) {
            $this->_lastHash = $this->takeHash();
        }
        return $this->_lastHash;
    }

    /**
     * @return string $hash
     * @throws InvalidConfigException
     */
    private function takeHash(): string
    {
        $hashUrl = $this->findRecord();
        if ($hashUrl) {
            return $hashUrl->hash;
        }
        $newModel = $this->createRecord();
        return $newModel->hash;
    }

    /**
     * @return HashUrl
     * @throws Exception
     */
    private function createRecord()
    {
        $model = new HashUrl();
        $model->load([
            'original_url' => $this->_originalUrl,
            'hash' => $this->_generatorStrategy->generate(),
            'md5_hash' => md5($this->_originalUrl, true),
        ], '');
        $validateResult = $model->validate();
        while (!$validateResult) {
            // update strategy dependency with new base
            $this->updateStrategy();
            $model->hash = $this->_generatorStrategy->generate();
            $validateResult = $model->validate();
        }
        $model->save();
        return $model;
    }

    /**
     * Update strategy
     * if not found set default BaseOnMillisecondHashGeneratorStrategy
     * @return void
     */
    private function updateStrategy(): void
    {
        $definitions = Yii::$container->getDefinitions();
        $currentDependencyName = array_keys(array_filter($definitions, function($v, $k) {
            return isset($v['class']) && $v['class'] === get_class($this->_generatorStrategy)
                ? true : false;
        }, ARRAY_FILTER_USE_BOTH))[0] ?? 'baseOnMillisecondHashGeneratorStrategy';
        $this->setGeneratorStrategy(Yii::$container->get($currentDependencyName));
    }

    /**
     * @return HashUrl|null
     */
    private function findRecord()
    {
        return HashUrl::find()
            ->where(['md5_hash' => md5($this->_originalUrl, true)])
            ->one();
    }
}
