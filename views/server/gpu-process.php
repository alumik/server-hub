<?php

use app\models\Server;
use yii\bootstrap4\Html;

/* @var $model Server */
/* @var $nvidiaOutput string */
/* @var $this yii\web\View */

$this->title = $model->name . '当前 GPU 进程';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = 'GPU 进程';
?>
<div class="server-gpu-process">

    <h1><?= Html::encode($this->title) ?></h1>

    <pre>
        <?= $nvidiaOutput ?>
    </pre>

</div>
