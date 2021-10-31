<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\models\SignupForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
        ],
    ]) ?>

    <?= $form->field($model, 'student_id')->textInput(['autofocus' => true, 'placeholder' => '学号/工号']) ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '大于等于6个字符']) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="row form-group">
        <div class="col-lg-1"></div>
        <div class="col-lg-11">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'singup-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>

</div>
