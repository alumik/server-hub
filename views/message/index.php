<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $messages array */
/* @var $changeLogs array */

$this->title = '公告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?php foreach ($messages as $message): ?>

        <div class="alert alert-<?= $message->mode ?>">
            <?= $message->text ?>
        </div>

    <?php endforeach ?>

    <h2 class="mt-4 mb-4">更新记录</h2>

    <?php foreach ($changeLogs as $changeLog): ?>

        <div class="card bg-light mb-3">
            <div class="card-body">
                <?= Markdown::process('### 版本 ' . $changeLog->version) ?>
                <hr/>
                <p>日期 <?= date('Y年m月d日', $changeLog->created_at) ?></p>
                <?= Markdown::process($changeLog->text) ?>
            </div>
        </div>

    <?php endforeach ?>

</div>
