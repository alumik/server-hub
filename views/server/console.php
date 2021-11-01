<?php

/* @var $model \app\models\Server */
/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = $model->name . '控制台';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = '控制台';
?>
<div class="server-console">

    <iframe
            class="console"
            src="http://10.10.1.210:2222/ssh/host/<?= $model->ip ?>"></iframe>

</div>
