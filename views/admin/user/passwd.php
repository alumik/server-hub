<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\UpdatePasswordForm */
/* @var $id int */

$this->title = '更新用户密码';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $id];
$this->params['breadcrumbs'][] = '更新密码';
?>
<div class="user-update">

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

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '大于等于6个字符']) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="row form-group">
        <div class="col-lg-1"></div>
        <div class="col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>

</div>
