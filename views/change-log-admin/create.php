<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ChangeLog */

$this->title = '新建更新记录';
$this->params['breadcrumbs'][] = ['label' => '更新管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新建';
?>
<div class="change-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
