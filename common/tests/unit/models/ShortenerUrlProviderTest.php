<?php

namespace common\tests\unit\models;

use Yii;
use common\fixtures\ShortenerUrlProviderFixture;

/**
 * ShortenerGenerator component test
 */
class ShortenerUrlProviderTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'provider' => [
                'class' => ShortenerUrlProviderFixture::className(),            
            ]
        ];
    }
}
