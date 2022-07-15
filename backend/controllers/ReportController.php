<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\search\ReportSearch;

/**
 * Report controller
 */
class ReportController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(array_merge(
            Yii::$app->request->queryParams,
            []
        ));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
