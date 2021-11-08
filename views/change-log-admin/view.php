<?php

use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ChangeLog */

$this->title = $model->version;
$this->params['breadcrumbs'][] = ['label' => '更新管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
YiiAsset::register($this);
?>
<div class="change-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该条更新记录吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
            ],
            'version',
            [
                'attribute' => 'text',
                'value' => Markdown::process($model->text),
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
