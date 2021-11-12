<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = '反馈';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        向服务器管理员匿名发送有关本平台或服务器的建议或反馈
    </p>

    <div class="feedback-form">

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 12]) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>

    </div>

</div>
