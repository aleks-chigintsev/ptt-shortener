<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\ShortenerForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Index page
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new ShortenerForm();

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
