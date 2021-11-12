<?php

use app\models\Dictionary;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\bootstrap4\ActiveForm */
?>
<div class="message-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form
        ->field($model, 'mode')
        ->dropdownList(ArrayHelper::map(Dictionary::find()->where(['name' => 'message_mode'])->orderBy('sort')->all(), 'key', 'value')) ?>

    <?= $form->field($model, 'show')->checkbox() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
