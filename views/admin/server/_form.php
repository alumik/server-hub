<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Server */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="server-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true])->label('服务器 IP') ?>

    <?= $form->field($model, 'instance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gpu_instance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ssh_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'show')->checkbox() ?>

    <?= $form->field($model, 'show_gpu')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
