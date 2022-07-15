<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\HashUrl;
use backend\helpers\UtilHelper;

/**
 * Redirect controller
 */
class RedirectController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
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
    public function actionIndex(string $hash)
    {
        try {
            $model = $this->findModel($hash);
        } catch(\Throwable $e) {
            // if it is not found, we do not throw an exception, 
            // but simply send it to the main page
            return $this->redirect(Yii::$app->urlManager->createAbsoluteUrl('/'));
        }
        // by specification: 
        // https://docs.google.com/document/d/1iqu82SKCKdkdxyTTQN8v6Y7Myb7oJTemeNXE7ZgPU9A/edit#
        // async run in PHP, OMG! :)
        // this can only be achieved with crutches
        // use exec method for fast impl
        // (popen not need: we are not waiting for anything, if only for debugging)
        exec(UtilHelper::getConsoleBashCommand('redirect/async-handler', [
            $model->hash_url_id,
            Yii::$app->request->userAgent
        ]));
        return $this->redirect($model->original_url);
    }

    /**
     * @param string $hash
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel(string $hash)
    {
        if (($model = HashUrl::findOne(['hash' => $hash])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Hash [{$hash}] not found!');
    }
}
