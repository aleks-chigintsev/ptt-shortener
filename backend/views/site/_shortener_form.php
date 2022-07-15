<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
Icon::map($this);

/* @var $this yii\web\View */
/* @var $form backend\models\ShortenerForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'sf__form',
        'action' => '/shortener-form/save',
        'enableAjaxValidation' => true,
        'validationUrl' => '/shortener-form/validate',
    ]); ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сократить', ['class' => 'btn btn-success']) ?>
    </div>
    
    <div class="jumbotron">
        <h4>Ваша ссылка:</h4>
        <?= 
            $form->field($model, 'hash', [
            'template' => '
                <div class="input-group">
                    <div class="col-2 sf__copy-to-buffer" onclick="sfCopyToClickboard(event);">
                        ' . Icon::show('copy', ['class'=>'fa-2x']) . '
                    </div>
                    <div class="col-10">
                        {input}
                    </div>
                </div>
                {error}{hint}'
            ])->textInput([
                'class' => 'form-control shortener-form-result',
                'disabled' => 'disabled'
            ])->label(false)
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
