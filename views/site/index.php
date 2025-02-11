<?php

use yii\bootstrap4\Html;
use yii\helpers\Markdown;

/* @var $messages array */

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center">
        <?= Html::img('@web/img/nankai-logo-full.svg', ['alt' => '南开大学', 'class' => 'jumbotron-logo']) ?>
        <h1>南开大学软件学院智能计算实验室<br/>服务器作业管理平台</h1>
    </div>

    <div class="body-content">
        <?php foreach ($messages as $message): ?>

            <div class="bd-callout bd-callout-<?= $message->mode ?> d-flex flex-row justify-content-between">
                <div><?= Markdown::process($message->content) ?></div>
                <div class="far fa-clock text-secondary text-nowrap text-right ml-3"> <?=  Yii::$app->formatter->asRelativeTime($message->created_at) ?></div>
            </div>

        <?php endforeach ?>
    </div>

</div>
