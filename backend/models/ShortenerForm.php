<?php

namespace backend\models;

use Yii;

/**
 * Form generate short url
 */
class ShortenerForm extends HashUrl
{
    /**
     * @var string $url raw text from url-input
     */
    public $url;

    /**
     * @var string $hash
     */
    public $hash;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['url'], 'safe'],
            ['url', 'string', 'skipOnEmpty' => false],
            ['url', 'url', 'skipOnEmpty' => false],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels(): array
    {
        return [
            'url' => 'URL-адрес',
        ];
    }
}
