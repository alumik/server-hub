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
            ->dropdownList(ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value')) ?>

        <?= $form
            ->field($model, 'id_server')
            ->dropdownList(ArrayHelper::map(Server::find()->orderBy('name')->all(), 'id', 'name')) ?>

        <?= $form->field($model, 'server_user')->textInput(['placeholder' => '执行该作业所用的服务器用户名']) ?>

        <?= $form->field($model, 'pid')->textInput(['placeholder' => '进程 PID (可选)']) ?>

        <?= $form->field($model, 'comm')->textInput(['placeholder' => 'Top 等工具可以看到的 Command 字段 (可选)']) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 8]) ?>

        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>

    </div>

</div>
