<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Changelog */

$this->title = '新建更新记录';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = ['label' => '更新管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新建';
?>
<div class="changelog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 15]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
