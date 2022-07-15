<?php

use backend\assets\ShortenerFormAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
ShortenerFormAsset::register($this);
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">

            <div class="col-12">
                <h1>Сокращение ссылки</h1>
            </div>
            
            <div class="col-12">
                <?= $this->render('_shortener_form', [
                    'model' => $model,
                ]) ?>
            </div>
            
        </div>

    </div>
</div>
