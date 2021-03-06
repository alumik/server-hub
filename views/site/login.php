<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>欢迎使用南开大学软件学院服务器作业管理平台</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
        ],
    ]) ?>

    <?= $form->field($model, 'student_id')->textInput(['autofocus' => true, 'maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="row form-group">
        <div class="col-lg-1"></div>
        <div class="col-lg-11">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>

</div>
