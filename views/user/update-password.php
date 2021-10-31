<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\models\SignupForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = ['label' => '个人中心', 'url' => '/user'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'id' => 'signup-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
        ],
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '大于等于6个字符']) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <div class="row form-group">
        <div class="col-lg-1"></div>
        <div class="col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success', 'name' => 'save-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
