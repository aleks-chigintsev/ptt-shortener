<?php

use common\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчеты по переходам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'label' => 'Месяц (перехода по ссылке)',
                        'value' => function($row) {
                            return $row['ym'];
                        }
                    ],
                    [
                        'label' => 'Ссылка',
                        'value' => function($row) {
                            return $row['original_url'];
                        }
                    ],
                    [
                        'label' => 'Кол-во переходов',
                        'value' => function($row) {
                            return $row['count'];
                        }
                    ],
                    [
                        'label' => 'Позиция в топе месяца по переходам',
                        'value' => function($row) {
                            return $row['top'];
                        }
                    ]
                ],
            ]); ?>
        </div>
    
    </div>

</div>
