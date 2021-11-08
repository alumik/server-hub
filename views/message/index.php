<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $messages array */
/* @var $changeLogs array */

$this->title = '平台公告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php foreach ($messages as $message): ?>

        <div class="card bg-<?= $message->mode ?> text-white mb-2">
            <div class="card-body">
                <?= $message->text ?>
            </div>
        </div>

    <?php endforeach ?>

    <h2>更新记录</h2>

    <?php foreach ($changeLogs as $changeLog): ?>

        <div class="card bg-light mb-2">
            <div class="card-header">
                <h4 class="mb-0"><?= '版本 ' . $changeLog->version ?></h4>
            </div>
            <div class="card-body">
                <p>日期 <?= date('Y年m月d日', $changeLog->created_at) ?></p>
                <?= Markdown::process($changeLog->text) ?>
            </div>
        </div>

    <?php endforeach ?>

</div>
