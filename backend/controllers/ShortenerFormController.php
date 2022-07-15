<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\ShortenerForm;
use yii\filters\VerbFilter;

/**
 * Controller with actions for ShortenerForm
 */
class ShortenerFormController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'validate' => ['post'],
                    'save' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeAction($action): bool
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @return array
     */
    public function actionValidate(): array
    {
        $model = new ShortenerForm();
        $request = Yii::$app->getRequest();
        if ($model->load($request->post())) {
            return ActiveForm::validate($model);
        }
    }

    /**
     * @return array
     */
    public function actionSave(): array
    {
        $model = new ShortenerForm();
        $request = Yii::$app->getRequest();
        if ($model->load($request->post())) {
            $shortenerUrlProvider = Yii::$container->get(
                'shortenerUrlProvider', 
                [$model->url],
            );
            return [
                'url' => Yii::$app->urlManager
                    ->createAbsoluteUrl($shortenerUrlProvider->hash),
            ];
        }
    }
}
