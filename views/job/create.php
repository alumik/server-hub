<?php

use app\models\Dictionary;
use app\models\Server;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = '新建作业记录';
$this->params['breadcrumbs'][] = ['label' => '作业记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新建';
?>
<div class="job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="job-form">

        <?php $form = ActiveForm::begin() ?>

        <?= $form
            ->field($model, 'duration')
            ->dropdownList(ArrayHelper::map(
                Dictionary::find()
                    ->where(['name' => 'job_duration', 'enabled' => true])
                    ->orderBy('sort')
                    ->all(),
                'key',
                'value')) ?>

        <?= $form
            ->field($model, 'id_server')
            ->dropdownList(ArrayHelper::map(Server::find()->orderBy('ip')->all(), 'id', 'ip')) ?>

        <?= $form->field($model, 'server_user')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pid')->textInput(['placeholder' => '若需使用 GPU，填写 nvidia-smi 中显示的 PID']) ?>

        <?= $form->field($model, 'comm')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'use_gpu')->checkbox() ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 8]) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>

    </div>

</div>
