<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = '新建公告';
$this->params['breadcrumbs'][] = ['label' => '公告管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
