<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChangeLog */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="change-log-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
