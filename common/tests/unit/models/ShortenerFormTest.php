<?php

namespace common\tests\unit\models;

use Yii;
use common\fixtures\HashUrlFixture;

/**
 * Short form test
 */
class ShortFormTest extends \Codeception\Test\Unit
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
            'user' => [
                'class' => HashUrlFixture::className(),
                'dataFile' => codecept_data_dir() . 'hash_url.php'
            ]
        ];
    }
}
