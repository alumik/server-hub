<?php

use yii\bootstrap4\Html;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $changelogs array */

$this->title = '更新记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="accordion" role="tablist" aria-multiselectable="true">

        <?php foreach ($changelogs as $index => $changelog): ?>

            <div class="card bg-light mb-3">
                <h5 class="card-header" role="tab" id="heading-<?= $index ?>">
                    <a data-toggle="collapse"
                       data-parent="#accordion"
                       href="#changelog-<?= $index ?>"
                       aria-expanded="true"
                       aria-controls="changelog-<?= $index ?>"
                       class="<?= $index == 0 ? '' : 'collapsed' ?> d-block">
                        <i class="fa fa-chevron-down float-right"></i>
                        <?= '版本 ' . $changelog->version ?>
                    </a>
                </h5>
                <div id="changelog-<?= $index ?>" class="collapse <?= $index == 0 ? 'show' : '' ?> " role="tabpanel"
                     aria-labelledby="heading-<?= $index ?>">
                    <div class="card-body">
                        <p>日期 <?= date('Y年m月d日', $changelog->created_at) ?></p>
                        <?= Markdown::process($changelog->content) ?>
                    </div>
                </div>
            </div>

        <?php endforeach ?>

    </div>

</div>
