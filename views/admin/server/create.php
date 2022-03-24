<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Server */

$this->title = '新建服务器';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = ['label' => '服务器管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
